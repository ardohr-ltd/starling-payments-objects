<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Request to create a payment account address.
 */

use Consilience\Starling\Payments\Request\Models\Endpoint;
use Consilience\Starling\Payments\AbstractRequest;
use Consilience\Starling\Payments\Request\Models\CreatePaymentAccountAddressRequest;

class CreatePaymentAccountAddress extends AbstractRequest
{
    /**
     * @inherit
     */
    protected $pathTemplate = 'account/{accountUid}/address/{addressUid}';

    protected $httpMethod = 'PUT';

    protected $accountUid;
    protected $addressUid;
    protected $createPaymentAccountAddressRequest;

    /**
     * @param string $paymentBusinessUid
     * @param string $accountUid the account to create the address for
     * @param string $addressUid the new UID to assign to the address
     */
    public function __construct(
        Endpoint $endpoint,
        $accountUid,
        $addressUid,
        CreatePaymentAccountAddressRequest $createPaymentAccountAddressRequest
    ) {
        $this->setEndpoint($endpoint);
        $this->setAccountUid($accountUid);
        $this->setAddressUid($addressUid);
        $this->setCreatePaymentAccountAddressRequest($createPaymentAccountAddressRequest);
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
     * @param CreatePaymentAccountAddressRequest
     */
    protected function setCreatePaymentAccountAddressRequest(CreatePaymentAccountAddressRequest $value)
    {
        $this->createPaymentAccountAddressRequest = $value;
    }

    /**
     * @return CreatePaymentAccountAddressRequest for serializing
     */
    public function jsonSerialize(): mixed
    {
        return $this->getProperty('createPaymentAccountAddressRequest');
    }
}
