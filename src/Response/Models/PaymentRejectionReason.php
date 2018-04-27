<?php

namespace Consilience\Starling\Payments\Response\Models;

/**
 * Reason the payment was rejected, only present when the status is ‘REJECTED’.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ModelInterface;

class PaymentRejectionReason implements ModelInterface
{
    use HydratableTrait;

    /**
     * @var string
     * Unique identifier of the reason for rejection.
     */
    protected $code;

    /**
     * @var string
     * Human-readable description of the rejection reason.
     */
    protected $description;

    /**
     * @return bool true if this object contains a value.
     */
    public function hasValues()
    {
        return $this->code !== null || $this->description !== null;
    }
}
