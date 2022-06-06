<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Create a new payment account.
 */

use Consilience\Starling\Payments\Request\Models\Endpoint;
use Consilience\Starling\Payments\Request\Models\CreatePaymentAccountRequest;

class CreatePaymentAccount extends GetPaymentAccount
{
    protected $httpMethod = 'PUT';

    protected $createPaymentAccountRequest;

    /**
     * @param string $paymentBusinessUid
     * @param string $accountUid the new UID to assign to this account
     */
    public function __construct(
        Endpoint $endpoint,
        $accountUid,
        CreatePaymentAccountRequest $createPaymentAccountRequest
    ) {
        parent::__construct($endpoint, $accountUid);

        $this->setCreatePaymentAccountRequest($createPaymentAccountRequest);
    }

    /**
     * @param string CreatePaymentAccountRequest
     */
    protected function setCreatePaymentAccountRequest(CreatePaymentAccountRequest $value)
    {
        $this->createPaymentAccountRequest = $value;
    }

    /**
     * @return CreatePaymentAccountRequest object for serializing
     */
    public function jsonSerialize(): mixed
    {
        return $this->getProperty('createPaymentAccountRequest');
    }
}
