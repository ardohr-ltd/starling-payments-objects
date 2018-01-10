<?php

namespace Consilience\Starling\Payments\Response\Models;

/**
 *
 */

use Consilience\Starling\Payments\HydratableTrait;

class ErrorDetail implements \JsonSerializable
{
    use HydratableTrait;

    /**
     * @var string
     * The error message.
     */
    protected $message;
}
