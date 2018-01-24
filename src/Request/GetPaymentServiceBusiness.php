<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Request to get the Payment Service Business details.
 */

use Consilience\Starling\Payments\Request\Model\Endpoint;
use Consilience\Starling\Payments\AbstractRequest;
use UnexpectedValueException;

class GetPaymentServiceBusiness extends AbstractRequest
{
    /**
     * @inherit
     */
    protected $pathTemplate = '';

    protected $method = 'GET';

    /**
     * @param string $paymentBusinessUid
     */
    public function __construct(Endpoint $endpoint)
    {
        $this->setEndpoint($endpoint);
    }
}
