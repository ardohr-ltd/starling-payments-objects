<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Change an account address faster pauments status.
 *
 * Changes the faster payments status of the account,
 * for instance marking the address as incoming or
 * outgoing payments disabled.
 */

use Consilience\Starling\Payments\Request\Models\Endpoint;
use Consilience\Starling\Payments\AbstractRequest;
use Consilience\Starling\Payments\Request\Models\ChangeFasterPaymentsStatusPaymentAccountAddressRequest;

class UpdatePaymentAccountAddressFasterPaymentsStatus extends AbstractRequest
{
    /**
     * @inherit
     */
    protected $pathTemplate = 'account/{accountUid}/address/{addressUid}/faster-payments-status';

    protected $httpMethod = 'PUT';

    protected $accountUid;
    protected $addressUid;
    protected $changeFasterPaymentsStatusPaymentAccountAddressRequest;

    /**
     * @param string $paymentBusinessUid
     * @param string $accountUid the accound to create the address for
     * @param string $addressUid the new UID to assign to the address
     * @param ChangeFasterPaymentsStatusPaymentAccountAddressRequest $status
     */
    public function __construct(
        Endpoint $endpoint,
        $accountUid,
        $addressUid,
        ChangeFasterPaymentsStatusPaymentAccountAddressRequest $status
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
     * @param ChangeFasterPaymentsStatusPaymentAccountAddressRequest
     */
    protected function setChangeFasterPaymentsStatusPaymentAccountAddressRequest(
        $value
    ) {
        $this->status = $value;
    }

    /**
     * @return array for serializing
     */
    public function jsonSerialize(): mixed
    {
        return $this->getProperty(
            'changeFasterPaymentsStatusPaymentAccountAddressRequest'
        );
    }
}
