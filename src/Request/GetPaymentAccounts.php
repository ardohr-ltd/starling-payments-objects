<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Request to get a list of payment accounts.
 */

use Consilience\Starling\Payments\Request\Models\Endpoint;
use Consilience\Starling\Payments\AbstractRequest;
use UnexpectedValueException;

class GetPaymentAccounts extends AbstractRequest
{
    /**
     * @inherit
     */
    protected $pathTemplate = 'account';

    protected $method = 'GET';

    /**
     * @param string $paymentBusinessUid
     */
    public function __construct(Endpoint $endpoint)
    {
        $this->setEndpoint($endpoint);
    }
}
