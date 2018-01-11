<?php

namespace Consilience\Starling\Payments\Response\Models;

/**
 *
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ModelInterface;

class ErrorDetail implements ModelInterface
{
    use HydratableTrait;

    /**
     * @var string
     * The error message.
     */
    protected $message;
}
