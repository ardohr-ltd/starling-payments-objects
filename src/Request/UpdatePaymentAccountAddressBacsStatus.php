<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Request to change the address bacs status.
 */

use Consilience\Starling\Payments\Request\Models\Endpoint;
use Consilience\Starling\Payments\AbstractRequest;
use UnexpectedValueException;
use Consilience\Starling\Payments\Request\Models\ChangeBacsStatusPaymentAccountAddressRequest;

class UpdatePaymentAccountAddressBacsStatus extends AbstractRequest
{
    /**
     * @inherit
     */
    protected $pathTemplate = 'account/{accountUid}/address/{addressUid}/bacs-payments-status';

    protected $httpMethod = 'PUT';

    protected $accountUid;
    protected $addressUid;
    protected $changeBacsStatusPaymentAccountAddressRequest;

    /**
     * @param string $paymentBusinessUid
     * @param string $accountUid the accound to create the address for
     * @param string $addressUid the new UID to assign to the address
     * @param ChangeBacsStatusPaymentAccountAddressRequest $status
     */
    public function __construct(
        Endpoint $endpoint,
        $accountUid,
        $addressUid,
        ChangeBacsStatusPaymentAccountAddressRequest $status
    ) {
        $this->setEndpoint($endpoint);
        $this->setAccountUid($accountUid);
        $this->setAddressUid($addressUid);
        $this->setChangeFasterPaymentsStatusPaymentAccountAddressRequest($status);
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
     * @param ChangeBacsStatusPaymentAccountAddressRequest
     */
    protected function setChangeFasterPaymentsStatusPaymentAccountAddressRequest(
        $value
    ) {
        $this->status = $value;
    }

    /**
     * @return array for serializing
     */
    public function jsonSerialize()
    {
        return $this->getProperty(
            'changeBacsStatusPaymentAccountAddressRequest'
        );
    }
}
