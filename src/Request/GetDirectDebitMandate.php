<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Gets a specific direct debit mandate associated with the specified address.
 */

use Consilience\Starling\Payments\Request\Models\Endpoint;
use Consilience\Starling\Payments\AbstractRequest;
use UnexpectedValueException;

class GetDirectDebitMandate extends AbstractRequest
{
    /**
     * @inherit
     */
    protected $pathTemplate = 'account/{accountUid}/address/{addressUid}/mandate/{mandateUid}';

    protected $httpMethod = 'GET';

    protected $accountUid;
    protected $addressUid;
    protected $mandateUid;

    /**
     * @param string $paymentBusinessUid
     * @param string $accountUid the accound to retrieve
     */
    public function __construct(Endpoint $endpoint, $accountUid, $addressUid, $mandateUid)
    {
        $this->setEndpoint($endpoint);
        $this->setAccountUid($accountUid);
        $this->setAddressUid($addressUid);
        $this->setMandateUid($mandateUid);
    }

    /**
     * @param string UID
     */
    protected function setAccountUid($value)
    {
        $this->assertUid($value);

        $this->accountUid = $value;
    }

    /**
     * @param string UID
     */
    protected function setAddressUid($value)
    {
        $this->assertUid($value);

        $this->addressUid = $value;
    }

    /**
     * @param string UID
     */
    protected function setMandateUid($value)
    {
        $this->assertUid($value);

        $this->mandateUid = $value;
    }
}
