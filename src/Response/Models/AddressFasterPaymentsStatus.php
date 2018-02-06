<?php

namespace Consilience\Starling\Payments\Response\Models;

/**
 *
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ModelInterface;

class AddressFasterPaymentsStatus implements ModelInterface
{
    use HydratableTrait;

    /**
     * @var string one of static::ADDRESS_FPS_STATUS_*
     */
    protected $inboundStatus;

    /**
     * @var string one of static::ADDRESS_FPS_STATUS_*
     */
    protected $outboundStatus;

    /**
     * @return bool true if the inbound FPS is enabled
     */
    public function isInboundEnabled()
    {
        return $this->inboundStatus === static::ADDRESS_FPS_STATUS_ENABLED;
    }

    /**
     * @return bool true if the outbound FPS is enabled
     */
    public function isOutboundEnabled()
    {
        return $this->outboundStatus === static::ADDRESS_FPS_STATUS_ENABLED;
    }
}
