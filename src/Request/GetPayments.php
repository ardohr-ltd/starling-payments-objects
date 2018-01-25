<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Request to get a single payment account.
 */

use Consilience\Starling\Payments\Request\Models\Endpoint;
use Consilience\Starling\Payments\AbstractRequest;
use UnexpectedValueException;

class GetPayments extends AbstractRequest
{
    /**
     * @inherit
     */
    protected $pathTemplate = 'account/{accountUid}/address/{addressUid}/payment';

    protected $httpMethod = 'GET';

    protected $supportedQuery = ['direction', 'from', 'to', 'page'];

    protected $accountUid;
    protected $addressUid;

    protected $direction;
    protected $from;
    protected $to;
    protected $page;

    /**
     * @param string $paymentBusinessUid
     * @param string $accountUid the accound to retrieve
     */
    public function __construct(
        Endpoint $endpoint,
        $accountUid,
        $addressUid,
        $direction = null,
        $from = null,
        $to = null,
        $page = null
    ) {
        $this->setEndpoint($endpoint);
        $this->setAccountUid($accountUid);
        $this->setAddressUid($addressUid);

        $this->setDirection($direction);
        $this->setFrom($from);
        $this->setTo($to);
        $this->setPage($page);
    }

    /**
     * @param string UUID
     */
    protected function setAccountUid($value)
    {
        $this->accountUid = $value;
    }

    /**
     * @param string UUID
     */
    protected function setAddressUid($value)
    {
        $this->addressUid = $value;
    }

    /**
     * @param string
     */
    protected function setDirection($value)
    {
        // One of the valid address ststuses.
        if ($value !== null) {
            $this->assertInConstantList('DIRECTION_', $value);
        }

        $this->direction = $value;
    }

    /**
     * @param TBC
     */
    protected function setFrom($value)
    {
        $this->from = $value;
    }

    /**
     * @param TBC
     */
    protected function setTo($value)
    {
        $this->to = $value;
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
