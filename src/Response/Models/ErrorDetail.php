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
     *
     * A message seems to come im two forms:
     * - an UPPER_CASE_TOKEN; or
     * - a four line document with lines terminated with \r
     *
     * TODO: some parsing of the message would be useful, as soon as some formal
     * documentation is available.
     */
    protected $message;
}
