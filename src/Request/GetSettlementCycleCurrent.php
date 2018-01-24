<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Request to get a summary of the current active settlement cycle.
 */

use Consilience\Starling\Payments\Request\Model\Endpoint;
use Consilience\Starling\Payments\AbstractRequest;
use UnexpectedValueException;

class GetSettlementCycleCurrent extends AbstractRequest
{
    /**
     * @inherit
     */
    protected $pathTemplate = 'settlement/current';

    protected $httpMethod = 'GET';

    /**
     * @param string $paymentBusinessUid
     */
    public function __construct(Endpoint $endpoint)
    {
        $this->setEndpoint($endpoint);
    }
}
