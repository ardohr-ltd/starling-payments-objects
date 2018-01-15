<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Retrieved payment business information.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ModelInterface;
use UnexpectedValueException;

use Consilience\Starling\Payments\Response\Models\CurrencyAndAmount;

class CreatePaymentAccountRequest implements ModelInterface
{
    use HydratableTrait;

    /**
     * @var maximum length of the description property.
     */
    const MAX_DESCRIPTION_LENGTH = 100;

    /**
     *
     */
    public function __construct($description, $accountHolder)
    {
        $this->setDescription($description);
        $this->setAccountHolder($accountHolder);
    }

    /**
     * @var string length 0 to 100
     * Description of the account, for internal reference.
     */
    protected $description;

    /**
     * @var string
     * Organisation name.
     */
    protected $accountHolder;

    /**
     * Description of the account, for internal reference.
     *
     * @param string max length 100
     */
    protected function setDescription($value)
    {
        if (! is_string($value)) {
            throw new UnexpectedValueException(sprintf(
                'Description must be a string; %s given',
                gettype($value)
            ));
        }

        if (strlen($value) > static::MAX_DESCRIPTION_LENGTH) {
            throw new UnexpectedValueException(sprintf(
                'Description maximum length is %d; %d givem',
                static::MAX_DESCRIPTION_LENGTH,
                strlen($value)
            ));
        }

        $this->description = $value;
    }

    /**
     * Type of the account holder, currently only AGENCY is supported.
     *
     * @param string one of static::ACCOUNT_HOLDER_*
     */
    protected function setAccountHolder($value)
    {
        $this->assertInConstantList('ACCOUNT_HOLDER_', $value);

        $this->accountHolder = $value;
    }
}
