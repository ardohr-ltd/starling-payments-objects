<?php

namespace Consilience\Starling\Payments\Response\Collections;

/**
 *
 */

use Consilience\Starling\Payments\Response\Models\ErrorDetail;

class ErrorDetailCollection extends AbstractCollection
{
    /**
     * @param mixed $item
     * @return bool
     */
    protected function hasExpectedStrictType($item)
    {
        return $item instanceof ErrorDetail;
    }
}
