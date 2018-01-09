<?php

namespace Consilience\Starling\Payments\Response;

/**
 * Details of a single payment that has been sent or received
 */

class PaymentDetails
{
    use HydratableTrait;

    /**
     * @var string
     */
    const DIRECTION_INBOUND = 'INBOUND';
    const DIRECTION_OUTBOUND = 'OUTBOUND';

    /**
     * @var string
     */
    const STATUS_PENDING = 'PENDING';
    const STATUS_ACCEPTED = 'ACCEPTED';
    const STATUS_REJECTED = 'REJECTED';
    const STATUS_REVERSED = 'REVERSED';

    /**
     * @var string
     */
    const TYPE_SIP = 'SIP';
    const TYPE_SOP = 'SOP';
    const TYPE_FDP = 'FDP';
    const TYPE_SRN = 'SRN';
    const TYPE_RTN = 'RTN';
    const TYPE_DCA = 'DCA';

    /**
     * @var string
     */
    const FPS_CYCLE_001 = 'CYCLE_001';
    const FPS_CYCLE_002 = 'CYCLE_002';
    const FPS_CYCLE_003 = 'CYCLE_003';

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
     * @var string One of static::DIRECTION_*
     * The direction of the payment.
     */
    protected $direction;

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
     * @var string one of static::STATUS_*
     * Status of the payment request.
     */
    protected $status;

    /**
     * @var PaymentRejectionReason
     * Reason the payment was rejected, only present when the status is ‘REJECTED’.
     */
    protected $rejectedReason;

    /**
     * @var string date-time e.g. 2017-06-05T11:47:58.801Z
     * Date and time that the request for payment was originally received.
     */
    protected $requestedAt;

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
        $this->sourceAccount = PaymentDetailsAccount::fromData($data);
    }

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setDestinationAccount(array $data)
    {
        $this->destinationAccount = PaymentDetailsAccount::fromData($data);
    }

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setSettlementAmount(array $data)
    {
        $this->settlementAmount = CurrencyAndAmount::fromData($data);
    }

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setInstructedAmount(array $data)
    {
        $this->instructedAmount = CurrencyAndAmount::fromData($data);
    }

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setRejectedReason(array $data)
    {
        $this->rejectedReason = PaymentRejectionReason::fromData($data);
    }

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setReturnDetails(array $data)
    {
        $this->returnDetails = PaymentReturnDetails::fromData($data);
    }
}