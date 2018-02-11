<?php

namespace Consilience\Starling\Payments\Response\Models;

/**
 * Currency and amount, in minor units.
 * Note: the amount will normally be returned from the API as the absolute
 * amount, always positive. Other properties or contexts will indicate what
 * the amount means.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ModelInterface;

use Money\Money;
use Money\Currency;

class CurrencyAndAmount implements ModelInterface
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
     * @return Money the absolute value, in most instances.
     */
    public function toMoney()
    {
        return new Money($this->minorUnits, new Currency($this->currency));
    }
}
