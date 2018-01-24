<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Request to get a single payment account.
 */

use Consilience\Starling\Payments\Request\Model\Endpoint;
use Consilience\Starling\Payments\AbstractRequest;
use UnexpectedValueException;

class GetPaymentAccount extends AbstractRequest
{
    /**
     * @inherit
     */
    protected $pathTemplate = 'account/{accountUid}';

    protected $accountUid;

    protected $method = 'GET';

    /**
     * @param string $paymentBusinessUid
     * @param string $accountUid the accound to retrieve
     */
    public function __construct(Endpoint $endpoint, $accountUid)
    {
        $this->setEndpoint($endpoint);
        $this->setAccountUid($accountUid);
    }

    /**
     * @param string UUID
     */
    protected function setAccountUid($value)
    {
        $this->accountUid = $value;
    }
}
