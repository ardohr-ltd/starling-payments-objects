<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Request to gets the details of a settlement cycle by unique identifier.
 */

use Consilience\Starling\Payments\Request\Model\Endpoint;
use Consilience\Starling\Payments\AbstractRequest;
use UnexpectedValueException;

class GetSettlementCycle extends AbstractRequest
{
    /**
     * @inherit
     */
    protected $pathTemplate = 'settlement/cycle/{settlementCycleUid}';

    protected $httpMethod = 'GET';

    protected $settlementCycleUid;

    /**
     * @param string $paymentBusinessUid
     */
    public function __construct(Endpoint $endpoint, $settlementCycleUid)
    {
        $this->setEndpoint($endpoint);
        $this->setSettlementCycleUid($settlementCycleUid);
    }

    /**
     * @param string UUID
     */
    protected function setSettlementCycleUid($value)
    {
        $this->settlementCycleUid = $value;
    }
}
