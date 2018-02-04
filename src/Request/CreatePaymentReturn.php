<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Returns a previously received inbound payment to the sender
 * with a given reason. If the payment received originated overseas,
 * the payment will be returned to the UK based instructing agent.
 */

use Consilience\Starling\Payments\Request\Models\Endpoint;
use Consilience\Starling\Payments\AbstractRequest;
use UnexpectedValueException;

use Consilience\Starling\Payments\Request\Models\PaymentReturnRequest;

class CreatePaymentReturn extends AbstractRequest
{
    /**
     * @inherit
     */
    protected $pathTemplate = 'account/{accountUid}/address/{addressUid}/payment/{paymentUid}/return';

    protected $httpMethod = 'PUT';

    protected $accountUid;
    protected $addressUid;
    protected $paymentUid;
    protected $paymentReturnRequest;

    /**
     * @param string $paymentBusinessUid
     * @param string $accountUid the accound to retrieve
     * @param string $paymentUid new UID for the return transaction
     */
    public function __construct(
        Endpoint $endpoint,
        $accountUid,
        $addressUid,
        $paymentUid,
        PaymentReturnRequest $paymentReturnRequest
    ) {
        $this->setEndpoint($endpoint);
        $this->setAccountUid($accountUid);
        $this->setAddressUid($addressUid);
        $this->setPaymentUid($paymentUid);
        $this->setPaymentReturnRequest($paymentReturnRequest);
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
     * @param PaymentReturnRequest
     */
    protected function setPaymentReturnRequest(PaymentReturnRequest $value)
    {
        $this->paymentReturnRequest = $value;
    }

    /**
     * @return PaymentReturnRequest for serializing
     */
    public function jsonSerialize()
    {
        return $this->getProperty('paymentReturnRequest');
    }
}
