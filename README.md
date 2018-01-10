
## Starling Bank Payments API Objects

This is a package for PHP 5.6 to stuff the response body messages
from requests to the
[Starling Payments API](https://developer.starlingbank.com/payments/docs#operations-tag-Web_Hook)

This package is veruy much in development, and will intially cover just
the response messages I am particularly interested in.
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

$paymentDetails = PaymentDetails::fromData($data);

// or

$paymentDetails = new PaymentDetails($data);
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

That's kind of the wqay it's going, and progress will be documented
here as it happens.

