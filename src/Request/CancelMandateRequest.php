<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Request to cancel a mandate.
 */

use Consilience\Starling\Payments\Request\Models\Endpoint;

class CancelMandateRequest extends ActivateMandateRequest
{
    /**
     * @inherit
     */
    protected $pathTemplate = 'account/{accountUid}/address/{addressUid}/mandate/{mandateUid}/cancel';

    protected $httpMethod = 'PUT';

    protected $mandateStatusCancellationReason;

    /**
     * @param string $paymentBusinessUid
     * @param string $accountUid the account UID
     * @param string $addressUid the UID of the address
     * @param string $addressUid the new UID to assign to the address
     * @param string $mandateStatusCancellationReason the reason code
     */
    public function __construct(
        Endpoint $endpoint,
        $accountUid,
        $addressUid,
        $mandateUid,
        $mandateStatusCancellationReason
    ) {
        $this->setEndpoint($endpoint);
        $this->setAccountUid($accountUid);
        $this->setAddressUid($addressUid);
        $this->setMandateStatusCancellationReason($mandateStatusCancellationReason);
    }

    /**
     * Type of the account holder, currently only AGENCY is supported.
     *
     * @param string one of static::ACCOUNT_HOLDER_*
     */
    protected function setMandateStatusCancellationReason($value)
    {
        $this->assertInConstantList('MANDATE_CANCELLATION_REASON_', $value);

        $this->mandateStatusCancellationReason = $value;
    }

    /**
     * @return CreatePaymentAccountAddressRequest for serializing
     */
    public function jsonSerialize(): mixed
    {
        $reason = $this->getProperty('mandateStatusCancellationReason');

        return [
            'mandateStatusCancellationReason' => $reason,
        ];
    }
}
