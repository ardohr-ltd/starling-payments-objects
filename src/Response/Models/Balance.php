<?php

namespace Consilience\Starling\Payments\Response\Models;

/**
 *
 */

use Consilience\Starling\Payments\HydratableTrait;

class Balance
{
    use HydratableTrait;

    /**
     * @var string
     */
    const BALANCE_STATE_IN_CREDIT = 'IN_CREDIT';
    const BALANCE_STATE_OVERDRAWN = 'OVERDRAWN';

    /**
     * @var CurrencyAndAmount
     */
    protected $currencyAndAmount;

    /**
     * @var string one of static::BALANCE_STATE_*
     */
    protected $balanceState;

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setCurrencyAndAmount(array $data)
    {
        $this->currencyAndAmount = CurrencyAndAmount::fromArray($data);
    }

    /**
     * @return bool true if the account is in credit
     */
    public function isInCredit()
    {
        return $this->balanceState === static::BALANCE_STATE_IN_CREDIT;
    }

    /**
     * @return bool true if the account is overdrawn
     */
    public function isOverdrawn()
    {
        return $this->balanceState === static::BALANCE_STATE_OVERDRAWN;
    }
}
