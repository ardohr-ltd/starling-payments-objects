<?php

namespace Consilience\Starling\Payments\Response\Models;

/**
 * Details of the bacs status for an account address.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ModelInterface;

class AddressBacsStatus implements ModelInterface
{
    use HydratableTrait;

    /**
     * Indicates if the account has been allowed by the account owner to
     * receive direct credit payments, if disabled then all direct credit
     * payments to this account will be rejected.
     *
     * @var string one of static::ADDRESS_FPS_STATUS_*
     */
    protected $directCreditPaymentsStatus;

    /**
     * Indicates if the account has been allowed by the account owner to
     * make direct debit payments, if disabled then all attempts to collect
     * direct debit payments and mandates from this account will be rejected.
     *
     * @var string one of static::ADDRESS_FPS_STATUS_*
     */
    protected $directDebitPaymentsStatus;

    /**
     * @return bool true if the direct credit payments are enabled
     */
    public function isCreditPaymentEnabled()
    {
        return $this->directCreditPaymentsStatus === static::ADDRESS_BACS_STATUS_ENABLED;
    }

    /**
     * @return bool true if the direct dedit payments is enabled
     */
    public function isDebitPaymentEnabled()
    {
        return $this->directDebitPaymentsStatus === static::ADDRESS_BACS_STATUS_ENABLED;
    }
}
