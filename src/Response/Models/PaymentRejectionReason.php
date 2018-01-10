<?php

namespace Consilience\Starling\Payments\Response\Models;

/**
 * Reason the payment was rejected, only present when the status is ‘REJECTED’.
 */

use Consilience\Starling\Payments\HydratableTrait;

class PaymentRejectionReason implements \JsonSerializable
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
