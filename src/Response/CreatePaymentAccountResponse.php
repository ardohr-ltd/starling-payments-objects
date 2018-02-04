<?php

namespace Consilience\Starling\Payments\Response;

/**
 * Retrieved payment account details.
 */

use Consilience\Starling\Payments\AbstractResponse;

class CreatePaymentAccountResponse extends AbstractResponse
{
    /**
     * @var string UUID
     * Unique identifier of the payment account.
     */
    protected $paymentAccountUid;
}
