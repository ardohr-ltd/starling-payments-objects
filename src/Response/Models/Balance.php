<?php

namespace Consilience\Starling\Payments\Response\Models;

/**
 *
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ModelInterface;

class Balance implements ModelInterface
{
    use HydratableTrait;

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

    /**
     * @return Money\Money the balance as a signed Money object
     *
     * This will be the real value, being positive for a balance
     * in credit and negative for am overdrawn balance.
     */
    public function toMoney()
    {
        return $this->currencyAndAmount->toMoney()->absolute()
            ->multiply($this->isOverdrawn() ? -1 : 1);
    }
}
