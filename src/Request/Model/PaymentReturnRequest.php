<?php

namespace Consilience\Starling\Payments\Request\Model;

/**
 * Request for a new payment account.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ValidationTrait;
use Consilience\Starling\Payments\ModelInterface;
use UnexpectedValueException;

class PaymentReturnRequest implements ModelInterface
{
    use HydratableTrait;
    use ValidationTrait;

    protected $paymentUid;
    protected $reference;
    protected $reason;

    /**
     * @param string $paymentUid The paymentUid being returned
     * @param string $reference The reference for the return transaction
     * @param string $reason The reason code; reason for returning
     */
    public function __construct($paymentUid, $reference, $reason)
    {
        $this->setPaymentUid($paymentUid);
        $this->setReference($reference);
        $this->setReason($reason);
    }

    /**
     * Description of the account, for internal reference.
     *
     * @param string max length 100
     */
    protected function setDescription($value)
    {
        $this->assertString($value, 0, static::DESCRIPTION_MAX_LENGTH);

        $this->description = $value;
    }

    /**
     * The UID for the payment being returned.
     *
     * @param string UUID
     */
    protected function setPaymentUid($value)
    {
        $this->paymentUid = $value;
    }

    /**
     * The reference for the return transaction.
     *
     * @param string
     */
    protected function setReference($value)
    {
        $this->reference = $value;
    }

    /**
     * The reason for returning the payment.
     *
     * @param string one of static::PAYMENT_RETURN_REASON_*
     */
    protected function setReason($value)
    {
        $this->assertInConstantList('PAYMENT_RETURN_REASON_', $value);

        $this->reason = $value;
    }
}
