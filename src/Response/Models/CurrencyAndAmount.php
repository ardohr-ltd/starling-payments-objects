<?php

namespace Consilience\Starling\Payments\Response\Models;

/**
 *
 */

use Consilience\Starling\Payments\HydratableTrait;
use Money\Money;
use Money\Currency;

class CurrencyAndAmount
{
    use HydratableTrait;

    /**
     * @var string
     * ISO-4217 3 character currency code.
     */
    protected $currency;

    /**
     * @var integer 64-bit integer
     * Amount in the minor units of the given currency; eg pence in GBP, cents in EUR.
     */
    protected $minorUnits;

    /**
     * Convert to a Money\Money object, for formatting, arrithmetic etc.
     *
     * @return Money
     */
    public function toMoney()
    {
        return new Money($this->minorUnits, new Currency($this->currency));
    }
}
