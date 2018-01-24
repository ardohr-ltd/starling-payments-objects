<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Request to get information about all the payments made within a settlement cycle.
 */

use Consilience\Starling\Payments\Request\Model\Endpoint;
use Consilience\Starling\Payments\AbstractRequest;
use UnexpectedValueException;

class GetSettlementCyclePayments extends AbstractRequest
{
    /**
     * @inherit
     */
    protected $pathTemplate = 'settlement/payments/{settlementCycleUid}';

    protected $method = 'GET';

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
