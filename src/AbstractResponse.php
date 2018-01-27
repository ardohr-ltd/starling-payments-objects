<?php

namespace Consilience\Starling\Payments;

/**
 * Support for generating a PSR-7 request message.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ValidationTrait;
use Consilience\Starling\Payments\ModelInterface;

use Consilience\Starling\Payments\Request\Models\Endpoint;

abstract class AbstractResponse implements ModelInterface
{
    use HydratableTrait;

    /**
     * Try to create a response object from PSR-7 message.
     */

    /**
     * Try to create a response object from a message body.
     * We make a guess what the response is from the contents.
     * We will normally know what kind of response we are expecting,
     * but this is just for convenience.
     *
     * @param mixed $data
     */
    public static fromData($data)
    {
        // TODO
    }
}
