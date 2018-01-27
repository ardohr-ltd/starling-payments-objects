<?php

namespace Consilience\Starling\Payments\Response;

/**
 * Retrieved payment account details.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\HasErrorsTrait;
use Consilience\Starling\Payments\ModelInterface;

class DomesticPaymentInstructionResponse implements ModelInterface
{
    use HydratableTrait;
    use HasErrorsTrait;

    /**
     * @var string UUID
     * Unique identifier of the instructed payment.
     */
    protected $paymentUid;
}
