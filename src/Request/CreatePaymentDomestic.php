<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Instructs a new domestic (within the UK) payment for an account,
 * via an address assigned to the account.
 */

use Consilience\Starling\Payments\Request\Models\Endpoint;
use Consilience\Starling\Payments\AbstractRequest;
use Consilience\Starling\Payments\Request\Models\DomesticPaymentInstructionRequest;

class CreatePaymentDomestic extends AbstractRequest
{
    /**
     * @inherit
     */
    protected $pathTemplate = 'account/{accountUid}/address/{addressUid}/payment/{paymentUid}/domestic';

    protected $httpMethod = 'PUT';

    protected $accountUid;
    protected $addressUid;
    protected $paymentUid;

    protected $domesticPaymentInstructionRequest;

    /**
     * @param string $paymentBusinessUid
     * @param string $accountUid the account to retrieve
     * @param string $paymentUid new UID for the return transaction
     */
    public function __construct(
        Endpoint $endpoint,
        $accountUid,
        $addressUid,
        $paymentUid,
        DomesticPaymentInstructionRequest $domesticPaymentInstructionRequest
    ) {
        $this->setEndpoint($endpoint);
        $this->setAccountUid($accountUid);
        $this->setAddressUid($addressUid);
        $this->setPaymentUid($paymentUid);

        $this->setDomesticPaymentInstructionRequest($domesticPaymentInstructionRequest);
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
    protected function setPaymentUid($value)
    {
        $this->assertUid($value);

        $this->paymentUid = $value;
    }

    /**
     * @param DomesticPaymentInstructionRequest
     */
    protected function setDomesticPaymentInstructionRequest(DomesticPaymentInstructionRequest $value)
    {
        $this->domesticPaymentInstructionRequest = $value;
    }

    /**
     * @return DomesticPaymentInstructionRequest for serializing
     */
    public function jsonSerialize(): mixed
    {
        return $this->getProperty('domesticPaymentInstructionRequest');
    }
}
