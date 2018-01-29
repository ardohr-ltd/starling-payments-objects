<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Request to get a list of payment accounts.
 * There is no pager or other filters on this endpoint at the time of writing.
 * That is a feature that must surely come soon.
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
