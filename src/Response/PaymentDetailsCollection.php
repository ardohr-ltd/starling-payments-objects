<?php

namespace Consilience\Starling\Payments\Response;

/**
 *
 */

use Consilience\Starling\Payments\Response\PaymentDetails;
use Consilience\Starling\Payments\AbstractCollection;

class PaymentDetailsCollection extends AbstractCollection
{
    /**
     * @param mixed $item
     * @return bool
     */
    protected function hasExpectedStrictType($item)
    {
        return $item instanceof PaymentDetails;
    }

    /**
     * @inherit
     */
    protected function createInstance(array $data)
    {
        return new PaymentDetails($data);
    }
}
