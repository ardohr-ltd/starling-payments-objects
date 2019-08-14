<?php

namespace Consilience\Starling\Payments\ServerRequest;

/**
 * Web hook payload for a notification received from the faster payment scheme.
 * Notification received from the faster payments scheme, typically this is a
 * change in the status of the payment such as an acknowledgement or rejection.
 */

use Consilience\Starling\Payments\AbstractServerRequest;

use Carbon\Carbon;
use Consilience\Starling\Payments\Response\Models\PaymentReturnDetails;
use Consilience\Starling\Payments\Response\Models\CurrencyAndAmount;
use Consilience\Starling\Payments\Response\Models\PaymentDetailsAccount;
use Consilience\Starling\Payments\Response\Models\PaymentRejectionReason;

class FpsInboundNotification extends AbstractServerRequest
{
    /**
     * @var string the endpoint path the webhook will be delivered on.
     */
    // phpcs:ignore
    protected $_webhookType = AbstractServerRequest::WEBHOOK_TYPE_FPS_INBOUND;

    /**
     * @var string UUID
     * Unique identifier of the payment within the scheme.
     * 42 character string, in which the last five characters are almost always spaces.
     */
    protected $fpid;

    /**
     * @var string UUID
     * Unique identifier of the company requesting or receiving the payment.
     */
    protected $paymentBusinessUid;

    /**
     * @var string UUID
     * Unique identifier of the account containing the funds sent or received.
     */
    protected $paymentAccountUid;

    /**
     * @var string UUID
     * Unique identifier of the address the payment was sent from or received to.
     */
    protected $addressUid;

    /**
     * @var string UUID
     * Unique identifier of the payment.
     */
    protected $paymentUid;

    /**
     * @var PaymentDetailsAccount
     */
    protected $sourceAccount;

    /**
     * @var PaymentDetailsAccount
     */
    protected $destinationAccount;

    /**
     * @var CurrencyAndAmount
     */
    protected $settlementAmount;

    /**
     * @var CurrencyAndAmount
     */
    protected $instructedAmount;

    /**
     * @var string
     * Reference included with the payment.
     */
    protected $reference;

    /**
     * @var string
     * Unstructured additional remittance information.
     * Up to 140 characters of free text.
     */
    protected $additionalRemittanceInformation;

    /**
     * @var string date-time e.g. 2017-06-05T11:47:58.801Z
     * Date and time that the payment was originally received.
     */
    protected $receivedAt;

    /**
     * @var PaymentReturnDetails
     */
    protected $returnDetails;

    /**
     * @var string one of static::TYPE_*
     * Type of the payment that was sent or received.
     */
    protected $type;

    /**
     * @var string UUID
     * Faster payment scheme identifier for the settlement cycle the payment is allocated to.
     */
    protected $settlementCycleUid;

    /**
     * @var string one of static::FPS_CYCLE_*
     * Type of the payment that was sent or received.
     */
    protected $fpsSettlementCycleId;

    /**
     * @var string date e.g. 2017-06-05
     * Faster payment scheme settlement date.
     */
    protected $fpsSettlementDate;

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setSourceAccount(array $data)
    {
        $this->sourceAccount = PaymentDetailsAccount::fromArray($data);
    }

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setDestinationAccount(array $data)
    {
        $this->destinationAccount = PaymentDetailsAccount::fromArray($data);
    }

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setSettlementAmount(array $data)
    {
        $this->settlementAmount = CurrencyAndAmount::fromArray($data);
    }

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setInstructedAmount(array $data)
    {
        $this->instructedAmount = CurrencyAndAmount::fromArray($data);
    }

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setReturnDetails(array $data)
    {
        $this->returnDetails = PaymentReturnDetails::fromArray($data);
    }

    /**
     * @return Carbon the requestedAt as a Carbon object, with timezone preserved.
     */
    public function getReceivedAtCarbon()
    {
        return Carbon::parse($this->receivedAt);
    }

    /**
     * @return Carbon the fpsSettlementDate as a Carbon object, UTC with 00:00 time.
     */
    public function getFpsSettlementDateCarbon()
    {
        // The ! prefix forces the time to zero.
        return Carbon::createFromFormat('!Y-m-d', $this->fpsSettlementDate, 'UTC');
    }

    /**
     * Other endpoints use the shorter `paymentUid`, so we provide this alias.
     */
    public function getAccountUid()
    {
        return $this->getProperty('paymentAccountUid');
    }
}
