<?php

namespace Consilience\Starling\Payments\Response;

/**
 *
 */

use Consilience\Starling\Payments\AbstractCollection;
use Consilience\Starling\Payments\Response\DirectDebitMandate;

class DirectDebitMandateCollection extends AbstractCollection
{
    /**
     * @param mixed $item
     * @return bool
     */
    protected function hasExpectedStrictType($item)
    {
        return $item instanceof DirectDebitMandate;
    }

    /**
     * @inherit
     */
    protected function createInstance(array $data)
    {
        return new DirectDebitMandate($data);
    }
}
