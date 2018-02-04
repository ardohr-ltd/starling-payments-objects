<?php

namespace Consilience\Starling\Payments\Response;

/**
 * Retrieved payment account details.
 */

use Consilience\Starling\Payments\AbstractResponse;

class CreatePaymentAccountAddressResponse extends AbstractResponse
{
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
