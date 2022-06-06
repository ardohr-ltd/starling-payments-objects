<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Change an account address status.
 */

use Consilience\Starling\Payments\Request\Models\Endpoint;
use Consilience\Starling\Payments\AbstractRequest;

class UpdatePaymentAccountAddressStatus extends AbstractRequest
{
    /**
     * @inherit
     */
    protected $pathTemplate = 'account/{accountUid}/address/{addressUid}/status';

    protected $httpMethod = 'PUT';

    protected $accountUid;
    protected $addressUid;
    protected $status;

    /**
     * @param string $paymentBusinessUid
     * @param string $accountUid the accound to create the address for
     * @param string $addressUid the new UID to assign to the address
     * @param string $status
     */
    public function __construct(
        Endpoint $endpoint,
        $accountUid,
        $addressUid,
        $status
    ) {
        $this->setEndpoint($endpoint);
        $this->setAccountUid($accountUid);
        $this->setAddressUid($addressUid);
        $this->setStatus($status);
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
     * @param string
     */
    protected function setStatus($value)
    {
        // One of the valid address statuses.
        $this->assertInConstantList('ADDRESS_STATUS_', $value);

        $this->status = $value;
    }

    /**
     * @return array for serializing
     */
    public function jsonSerialize(): mixed
    {
        return [
            'status' => $this->getProperty('status')
        ];
    }
}
