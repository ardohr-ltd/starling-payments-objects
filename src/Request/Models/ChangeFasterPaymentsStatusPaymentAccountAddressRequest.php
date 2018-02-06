<?php

namespace Consilience\Starling\Payments\Request\Models;

/**
 * Set the statuses for inbound and outbound FPS for an address.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ValidationTrait;
use Consilience\Starling\Payments\ModelInterface;

class ChangeFasterPaymentsStatusPaymentAccountAddressRequest extends ModelInterface
{
    use HydratableTrait;
    use ValidationTrait;

    protected $inboundStatus;

    protected $outboundStatus;

    public function __construct($inboundStatus, $outboundStatus)
    {
        $this->setProperty('inboundStatus', $inboundStatus);
        $this->setProperty('outboundStatus', $outboundStatus);
    }

    protected function setInboundStatus($value)
    {
        $this->assertInConstantList('ADDRESS_FPS_STATUS_', $value);

        $this->inboundStatus = $value;
    }

    protected function setOutboundStatus($value)
    {
        $this->assertInConstantList('ADDRESS_FPS_STATUS_', $value);

        $this->outboundStatus = $value;
    }
}
