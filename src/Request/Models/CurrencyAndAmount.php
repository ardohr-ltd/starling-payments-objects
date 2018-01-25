<?php

namespace Consilience\Starling\Payments\Request\Models;

/**
 *
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ValidationTrait;
use Consilience\Starling\Payments\ModelInterface;

use Consilience\Starling\Payments\Response\Models\CurrencyAndAmount as ResponseCurrencyAndAmount;

use Money\Money;
use Money\Currency;

class CurrencyAndAmount extends ResponseCurrencyAndAmount
{
    use ValidationTrait;

    /**
     * Instantiate from a Money\Money object.
     *
     * @param Money $money
     * @return self
     */
    public static function fromMoney(Money $money)
    {
        return new static($money->getCurrency()->getCode(), $money->getAmount());
    }

    /**
     * @param string $currency ISO 3-char code
     * @param integer $minorUnits the minor units in the given currency
     */
    public function __construct($currency, $minorUnits)
    {
        $this->setCurrency($currency);
        $this->setMinorUnits($minorUnits);
    }

    /**
     * @param string $value
     */
    protected function setCurrency($value)
    {
        // Validate that the value is a valid currency code,
        // even if it isn't supported by the bank (we can't really
        // know what is support).

        $this->assertCurrencyCode($value);

        $this->currency = $value;
    }

    /**
     * @param string $value
     */
    protected function setMinorUnits($value)
    {
        // Validate.

        $this->assertMinorUnit($value);

        $this->minorUnits = intval($value);
    }
}
