<?php

namespace Consilience\Starling\Payments;

/**
 * Support for generating a PSR-7 request message.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ModelInterface;

use Consilience\Starling\Payments\Request\Models\Endpoint;

abstract class AbstractServerRequest implements ModelInterface
{
    use HydratableTrait;
}
