<?php

namespace Consilience\Starling\Payments\Request\Models;

/**
 * Request to change the address bacs status.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ValidationTrait;
use Consilience\Starling\Payments\ModelInterface;

class ChangeBacsStatusPaymentAccountAddressRequest extends ModelInterface
{
    use HydratableTrait;
    use ValidationTrait;

    protected $directCreditPaymentsStatus;

    protected $directDebitPaymentsStatus;

    public function __construct($directCreditPaymentsStatus, $directDebitPaymentsStatus)
    {
        $this->setProperty('directCreditPaymentsStatus', $directCreditPaymentsStatus);
        $this->setProperty('directDebitPaymentsStatus', $directDebitPaymentsStatus);
    }

    protected function setInboundStatus($value)
    {
        $this->assertInConstantList('ADDRESS_BACS_STATUS_', $value);

        $this->directCreditPaymentsStatus = $value;
    }

    protected function setOutboundStatus($value)
    {
        $this->assertInConstantList('ADDRESS_BACS_STATUS_', $value);

        $this->directDebitPaymentsStatus = $value;
    }
}
