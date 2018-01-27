<?php

namespace Consilience\Starling\Payments\Response;

/**
 * Response to a request to change the status of a payment account address.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\HasErrorsTrait;
use Consilience\Starling\Payments\ModelInterface;

class ChangeStatusPaymentAccountAddressResponse implements ModelInterface
{
    use HydratableTrait;
    use HasErrorsTrait;

    /**
     * @var string UUID
     * Unique identifier of the payment account address.
     */
    protected $addressUid;
}
