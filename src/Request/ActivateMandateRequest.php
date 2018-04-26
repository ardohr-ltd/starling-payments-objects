<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Request to activate a mandate.
 */

use Consilience\Starling\Payments\Request\Models\Endpoint;
use Consilience\Starling\Payments\AbstractRequest;
use UnexpectedValueException;

class ActivateMandateRequest extends AbstractRequest
{
    /**
     * @inherit
     */
    protected $pathTemplate = 'account/{accountUid}/address/{addressUid}/mandate/{mandateUid}/activate';

    protected $httpMethod = 'PUT';

    protected $accountUid;
    protected $addressUid;
    protected $mandateUid;

    /**
     * @param string $paymentBusinessUid
     * @param string $accountUid the account UID
     * @param string $addressUid the UID of the address
     * @param string $addressUid the new UID to assign to the address
     */
    public function __construct(
        Endpoint $endpoint,
        $accountUid,
        $addressUid,
        $mandateUid
    ) {
        $this->setEndpoint($endpoint);
        $this->setAccountUid($accountUid);
        $this->setAddressUid($addressUid);
    }

    /**
     * @param string UUID
     */
    protected function setAccountUid($value)
    {
        $this->assertUid($value);

        $this->accountUid = $value;
    }

    /**
     * @param string UUID
     */
    protected function setAddressUid($value)
    {
        $this->assertUid($value);

        $this->addressUid = $value;
    }

    /**
     * @param string UUID
     */
    protected function setMandateUid($value)
    {
        $this->assertUid($value);

        $this->mandateUid = $value;
    }

    /**
     * @return CreatePaymentAccountAddressRequest for serializing
     */
    public function jsonSerialize()
    {
        return [];
    }
}
