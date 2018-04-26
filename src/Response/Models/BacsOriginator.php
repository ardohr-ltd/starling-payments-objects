<?php

namespace Consilience\Starling\Payments\Response\Models;

/**
 * A party that is able to set up direct debit mandates and
 * send and receive payments via BACS
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ModelInterface;

class BacsOriginator implements ModelInterface
{
    use HydratableTrait;

    /**
     * @var string UUID
     * Starling's unique identifier of the originator.
     */
    protected $originatorUid;

    /**
     * @var string 6 characters; example 987654
     * BACS's unique identifier of the originator.
     */
    protected $serviceUserNumber;

    /**
     * @var string 0 to 33 characters; example : "Southern Electric"
     * The name of the originator as registered with BACS.
     */
    protected $name;
}
