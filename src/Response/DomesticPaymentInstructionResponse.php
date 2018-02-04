<?php

namespace Consilience\Starling\Payments\Response;

/**
 * Retrieved payment account details.
 */

use Consilience\Starling\Payments\AbstractResponse;

class DomesticPaymentInstructionResponse extends AbstractResponse
{
    /**
     * @var string UUID
     * Unique identifier of the instructed payment.
     */
    protected $paymentUid;
}
