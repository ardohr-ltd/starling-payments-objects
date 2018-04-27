
## Starling Bank Payments API Objects

This is a package for PHP 5.6 to stuff the response body messages
from requests to the
[Starling Payments API](https://developer.starlingbank.com/payments/docs#operations-tag-Web_Hook)

This package is in development, and has intially covered just
the response messages I am particularly interested in.
Objects to generate the request message bodies are being added now.
The intention is to extend that to include the full PSR-7 message (body,
headers, relative path). To support path generation, the contextual
UUIDs (e.g. account ID when creating an account address) may need to be
added, so the constructors will change.

Additional objects can be submitted by Pull Request if they are something you
would like to see.

The request messags are not included in this package for the moment,
but they may be in due course. Again, I am happy to accept PRs to hurry
this along.

### The Approach

The [Starling Payments API](https://developer.starlingbank.com/payments/docs#operations-tag-Web_Hook)
uses JSON request and response bodies.
The JSON responses will decode to nested arrays of scalar values.
This package provides classes that instantiate objects from that data.

To start with, the classes are just dumb value objects that take the data in properties.
Over time, more logic will be added to the classes to intepret the property values
in a higher business sense.
In addition, the values will be parsed into more common objects such as
[Money](http://moneyphp.org) and [Carbon](http://carbon.nesbot.com/docs/)
to provide further leverage with the tools and support those libraries
come with.

### Simple Example

The [Previous Payments](https://developer.starlingbank.com/payments/docs)
API can be used to fetch a single payment from an account address through
this endpoint:

    /api/v1/{paymentBusinessUid}/account/{accountUid}/address/{addressUid}/payment/{paymentUid}

This returns a data structure similar to this example:

```json
{
  "paymentBusinessUid": "e43d3060-2c83-4bb9-ac8c-c627b9c45f8b",
  "paymentAccountUid": "5347699b-d205-4272-aac6-ee9d7f2dddcf",
  "addressUid": "c0cee51b-700b-481d-8ac5-e2cd75929ef1",
  "paymentUid": "a4edcefd-97b5-46fc-9e79-004fe8f171b7",
  "sourceAccount": {
    "sortCode": "040050",
    "accountNumber": "12345678",
    "bic": "SRLGGB2L",
    "iban": "GB29NWBK60161331926819",
    "accountName": "Bobby Tables"
  },
  "destinationAccount": {
    "sortCode": "040050",
    "accountNumber": "12345678",
    "bic": "SRLGGB2L",
    "iban": "GB29NWBK60161331926819",
    "accountName": "Bobby Tables"
  },
  "direction": "INBOUND",
  "settlementAmount": {
    "currency": "GBP",
    "minorUnits": 11223344
  },
  "instructedAmount": {
    "currency": "GBP",
    "minorUnits": 11223344
  },
  "reference": "ABCD123456",
  "status": "ACCEPTED",
  "rejectedReason": {
    "code": "1234",
    "description": "Beneficiary Sort Code/Account Number unknown"
  },
  "requestedAt": "2017-06-05T11:47:58.801Z",
  "returnDetails": {
    "paymentBeingReturned": "954cbfb3-0de0-4f62-8043-00c5ccee0f12",
    "code": "1234",
    "description": "Beneficiary Sort Code/Account Number unknown"
  },
  "type": "SIP",
  "settlementCycleUid": "bba786ce-3580-4576-9cad-28a6b8f1b228",
  "fpsSettlementCycleId": "CYCLE_001",
  "fpsSettlementDate": "2017-06-05"
}
```

Given that data structure as `$data`, the value object can be instantiated like this:

```php
use Consilience\Starling\Payments\Response\PaymentDetails;

$paymentDetails = PaymentDetails::fromArray($data);

// or

$paymentDetails = new PaymentDetails($data);

// or

$paymentDetails = PaymentDetails::fromResponse($psr7response);
```

Each property can then be referenced in a number of ways:

```php
$status = $paymentDetails->status;

// or

$status = $paymentDetails->getProperty('status');
```

The nested data will in turn be instantiated as value objects:

```php
$instructedCurrency = $paymentDetails->instructedAmount->currency;
```

The `instructedAmount` will be a `CurrencyAndAmount` value object.
That object supports conversion to `Money\Money`:

```php
$money = $paymentDetails->instructedAmount->toMoney();
var_dump($money);

/*
object(Money\Money)#28 (2) {
  ["amount":"Money\Money":private]=>
  string(3) "999"
  ["currency":"Money\Money":private]=>
  object(Money\Currency)#29 (1) {
    ["code":"Money\Currency":private]=>
    string(3) "GBP"
  }
}
*/
```

Other objects will have similar conversions.
For example, the date and datetime properties can be fetched by appending
the name with `Carbon` to return a `Carbon` object for the date.
For example:

```php
var_dump($paymentDetails->fpsSettlementDate);

/*
string(10) "2018-01-05"
*/

var_dump($paymentDetails->fpsSettlementDateCarbon);

/*
object(Carbon\Carbon)#32 (3) {
  ["date"]=>
  string(26) "2018-01-05 00:00:00.000000"
  ["timezone_type"]=>
  int(3)
  ["timezone"]=>
  string(3) "UTC"
}
*/
```

Datetime objects (i.e. timestamps) will be in the timezone they were supplied in.
Date objects (without a time) will be returned in the UTC timezone.

That's kind of the wqay it's going, and progress will be documented
here as it happens.

## Supported Messages

All request messages have namespace `Consilience\Starling\Payments\Request`.

All response messages have namespace `Consilience\Starling\Payments\Response`.

The following table lists the requests you can send,
and the object to hold the response.

Request | Response
-- | --
CreatePaymentAccount | CreatePaymentAccountResponse
CreatePaymentAccountAddress | CreatePaymentAccountAddressResponse
CreatePaymentDomestic | DomesticPaymentInstructionResponse
CreatePaymentReturn | PaymentReturnResponse
GetPayment | PaymentDetails
GetPaymentAccount | PaymentAccount
GetPaymentAccountAddress | PaymentAccountAddress
GetPaymentAccountAddresses | PaymentAccountAddressCollection
GetPaymentAccounts | PaymentAccountCollection
GetPaymentServiceBusiness | BusinessInformation
GetPayments | PaymentDetailsCollection
GetSettlementCycle | SettlementCycle
GetSettlementCycleCurrent | SettlementCycle
GetSettlementCycleLast | SettlementCycle
GetSettlementCyclePayments | PaymentDetailsCollection
UpdatePaymentAccountAddressStatus | ChangeStatusPaymentAccountAddressResponse
GetDirectDebitMandate | DirectDebitMandate
GetDirectDebitMandates | DirectDebitMandateCollection
ActivateMandateRequest | ActivateMandateResponse
CancelMandateRequest | CancelMandateResponse
TBC | PaymentOriginatingOverseasInstructionResponse

To create a response object, you can instantiate it with either the response
body data, or the reponse PSR-7 message. For example:

```php
use Consilience\Starling\Payments\Request\Models\Endpoint;
use Consilience\Starling\Payments\Request\GetPaymentServiceBusiness;
use Consilience\Starling\Payments\Response\BusinessInformation;

$endpoint = new Endpoint($myPaymentBusinessUid, Endpoint::INSTANCE_SANDBOX);
$message = new GetPaymentServiceBusiness($endpoint);

// $client is created to accept and send PSR-7 requests.
// Note also the client must use a signing provider suitable for
// the Starling Payments API.
$response = $client->send($message->getRequest());

// Create the response object from the HTTP respinse:
$responseObject = BusinessInformation::fromResponse($response);

var_dump($responseObject);

/*
object(Consilience\Starling\Payments\Response\BusinessInformation)#235 (4) {
  ["paymentBusinessUid":protected]=>
  string(36) "4b5de5aa-7752-21ea-8219-2f948454a2d1"
  ["name":protected]=>
  string(14) "My Business Name"
  ["netSenderCap":protected]=>
  object(Consilience\Starling\Payments\Response\Models\CurrencyAndAmount)#232 (3) {
    ["currency":protected]=>
    string(3) "GBP"
    ["minorUnits":protected]=>
    int(10000)
  }
}
*/
```

Building the request objects may include any of the following classes
in `Consilience\Starling\Payments\Request\Models`:

* CreatePaymentAccountAddressRequest
* CreatePaymentAccountRequest
* CurrencyAndAmount
* DomesticInstructionAccount
* DomesticPaymentInstructionRequest
* Endpoint
* PaymentReturnRequest

The response messages may contain the following lower-level models:

* Response\Models\AccountNumberAndSortCode
* Response\Models\CurrencyAndAmount
* Response\Models\PaymentDetailsAccount
* Response\Models\PaymentReturnDetails
* Response\Models\Balance
* Response\Models\ErrorDetail
* Response\Models\PaymentRejectionReason

Webhooks are supported:

* ServerRequest\FpsSchemeNotification
* ServerRequest\FpsInboundNotification
* ServerRequest\FpsRedirectionNotification
* ServerRequest\FpsReversalNotification (no tests yet)

* ServerRequest\AccountTransactionNotification (no tests yet)

* ServerRequest\MandateCreatedNotification
* ServerRequest\MandateCancelledNotification
* ServerRequest\MandateOriginatorChangedNotification
* ServerRequest\DirectCreditPaymentReceivedNotification
* ServerRequest\DirectDebitPaymentPaidNotification
* ServerRequest\DirectDebitPaymentRejectedNotification
