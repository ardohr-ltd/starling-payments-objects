<?php

namespace Consilience\Starling\Payments\Response\Models;

/**
 * Account number and sort code pair on the FPS scheme.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ModelInterface;

class AccountNumberAndSortCode implements ModelInterface
{
    use HydratableTrait;

    /**
     * @var string length 0 to 34 e.g. 12345678
     * Account number.
     */
    protected $accountNumber;

    /**
     * @var string length 6 e.g. 040050
     * Bank sort code.
     */
    protected $sortCode;
}
