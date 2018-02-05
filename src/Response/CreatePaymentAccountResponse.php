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

    /**
     * Other endpoints use the shorter `paymentUid`, so we provide this alias.
     */
    public function getAccountUid()
    {
        return $this->getProperty('paymentAccountUid');
    }
}
