<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Request to get information about all the payments made within a settlement cycle.
 */

use Consilience\Starling\Payments\Request\Models\Endpoint;
use Consilience\Starling\Payments\AbstractRequest;
use UnexpectedValueException;

class GetSettlementCyclePayments extends AbstractRequest
{
    /**
     * @inherit
     */
    protected $pathTemplate = 'settlement/payments/{settlementCycleUid}';

    protected $httpMethod = 'GET';

    protected $supportedQuery = ['page'];

    protected $settlementCycleUid;

    protected $page;

    /**
     * @param string $paymentBusinessUid
     */
    public function __construct(Endpoint $endpoint, $settlementCycleUid, $page = null)
    {
        $this->setEndpoint($endpoint);
        $this->setSettlementCycleUid($settlementCycleUid);
        $this->setPage($page);
    }

    /**
     * @param string UUID
     */
    protected function setSettlementCycleUid($value)
    {
        $this->settlementCycleUid = $value;
    }

    /**
     * @param string UUID
     */
    protected function setPage($value)
    {
        // Must be a positive integer, 1 or higher, but is option (null allowed)
        if ($value !== null) {
            $this->assertPageNumber($value);
        }

        $this->page = $value;
    }
}
