<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Request to get a summary of the current active settlement cycle.
 */

use Consilience\Starling\Payments\Request\Model\Endpoint;
use Consilience\Starling\Payments\AbstractRequest;
use UnexpectedValueException;

class GetSettlementCycleLast extends GetSettlementCycleCurrent
{
    /**
     * @inherit
     */
    protected $pathTemplate = 'settlement/last';
}
