<?php

namespace Consilience\Starling\Payments\Response;

/**
 *
 */

use Consilience\Starling\Payments\Response\PaymentAccountAddress;

class PaymentAccountAddressCollection extends AbstractCollection
{
    /**
     * @param mixed $item
     * @return bool
     */
    protected function hasExpectedStrictType($item)
    {
        return $item instanceof PaymentAccountAddress;
    }

    /**
     * @inherit
     */
    protected function createInstance(array $data)
    {
        return new PaymentAccountAddress($data);
    }
}
