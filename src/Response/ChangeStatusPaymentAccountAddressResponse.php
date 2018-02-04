<?php

namespace Consilience\Starling\Payments\Response;

/**
 * Response to a request to change the status of a payment account address.
 */

use Consilience\Starling\Payments\AbstractResponse;

class ChangeStatusPaymentAccountAddressResponse extends AbstractResponse
{
    /**
     * @var string UUID
     * Unique identifier of the payment account address.
     */
    protected $addressUid;
}
