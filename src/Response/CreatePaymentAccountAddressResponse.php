<?php

namespace Consilience\Starling\Payments\Response;

/**
 * Retrieved payment account details.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\HasErrorsTrait;
use Consilience\Starling\Payments\ModelInterface;

class CreatePaymentAccountAddressResponse implements ModelInterface
{
    use HydratableTrait;
    use HasErrorsTrait;

    /**
     * @var string UUID
     * Unique identifier of the payment account address.
     */
    protected $addressUid;

    /**
     * @var string example 11223344
     * UK account number allocated to the address.
     */
    protected $accountNumber;

    /**
     * @var string example 11223344
     * UK sort code allocated to the address.
     */
    protected $sortCode;
}
