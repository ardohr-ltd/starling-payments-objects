<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Request to get a single payment account.
 */

use Consilience\Starling\Payments\Request\Model\Endpoint;
use Consilience\Starling\Payments\AbstractRequest;
use UnexpectedValueException;

class GetPaymentAccountAddress extends AbstractRequest
{
    /**
     * @inherit
     */
    protected $pathTemplate = 'account/{accountUid}/address/{addressUid}';

    protected $httpMethod = 'GET';

    protected $accountUid;
    protected $addressUid;

    /**
     * @param string $paymentBusinessUid
     * @param string $accountUid the accound to retrieve
     */
    public function __construct(Endpoint $endpoint, $accountUid, $addressUid)
    {
        $this->setEndpoint($endpoint);
        $this->setAccountUid($accountUid);
        $this->setAddressUid($addressUid);
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
}
