<?php

namespace Consilience\Starling\Payments\Response\Collections;

/**
 *
 */

use Consilience\Starling\Payments\Response\PaymentDetails;

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
