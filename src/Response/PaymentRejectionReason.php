<?php

namespace Consilience\Starling\Payments\Response;

/**
 * Reason the payment was rejected, only present when the status is ‘REJECTED’.
 */

class PaymentRejectionReason
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
}
