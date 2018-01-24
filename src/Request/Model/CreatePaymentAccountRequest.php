<?php

namespace Consilience\Starling\Payments\Request\Model;

/**
 * Request for a new payment account.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ValidationTrait;
use Consilience\Starling\Payments\ModelInterface;
use UnexpectedValueException;

use Consilience\Starling\Payments\Response\Models\CurrencyAndAmount;

class CreatePaymentAccountRequest implements ModelInterface
{
    use HydratableTrait;
    use ValidationTrait;

    /**
     * @var maximum length of the description property.
     */
    const DESCRIPTION_MAX_LENGTH = 100;

    /**
     * @param string $description
     * @param string $accountHolder
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
        $this->assertString($value, 0, static::DESCRIPTION_MAX_LENGTH);

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
