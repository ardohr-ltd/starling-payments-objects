<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Request for a new address for a payment account.
 *
 * NOTE: this is just the request body data. There is also authentication
 * data, hash validation data for security and path data to idenify resources.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ValidationTrait;
use Consilience\Starling\Payments\ModelInterface;
use UnexpectedValueException;

use Consilience\Starling\Payments\Response\Models\CurrencyAndAmount;

class CreatePaymentAccountAddressRequest implements ModelInterface
{
    use HydratableTrait;
    use ValidationTrait;

    /**
     * @var minimum length of the accountName property.
     */
    const ACCOUNT_NAME_MIN_LENGTH = 1;

    /**
     * @var maximum length of the accountName property.
     */
    const ACCOUNT_NAME_MAX_LENGTH = 40;

    /**
     * @var minimum length of the sortCode property.
     */
    const SORT_CODE_MIN_LENGTH = 6;

    /**
     * @var maximum length of the sortCode property.
     */
    const SORT_CODE_MAX_LENGTH = 6;

    /**
     * @var minimum length of the accountNumber property.
     */
    const ACCOUNT_NUMBER_MIN_LENGTH = 8;

    /**
     * @var maximum length of the accountNumber property.
     */
    const ACCOUNT_NUMBER_MAX_LENGTH = 8;

    /**
     * @var string length 0 to 40
     * Name of the account holder, this will be included in outbound payment instructions.
     */
    protected $accountName;

    /**
     * @var string
     * UK sort code for sending and receiving payments, must be within the set of sort
     * codes allocated to the payment business.
     */
    protected $sortCode;

    /**
     * UK account number for sending and receiving payments. Typically account number
     * assignment is managed by Starling and this value must be blank. For some sort
     * codes, account number assignment is managed by the client and the account number
     * must be specified, valid within any modulus checks active on the sort code and
     * have never previously been used for the sort code.
     */
    protected $accountNumber;

    /**
     *
     */
    public function __construct($accountName, $sortCode, $accountNumber = null)
    {
        $this->setAccountName($accountName);
        $this->setSortCode($sortCode);

        if ($accountNumber !== null) {
            $this->setAccountNumber($accountNumber);
        }
    }

    /**
     * Name of the account holder, this will be included in outbound payment instructions.
     *
     * @param string max length 100
     */
    protected function setAccountName($value)
    {
        $this->assertString(
            $value,
            static::ACCOUNT_NAME_MIN_LENGTH,
            static::ACCOUNT_NAME_MAX_LENGTH,
            '/^[a-zA-Z0-9-\/?:().+#=!%&*<>;{@ "\']{1,40}$/'
        );

        $this->accountName = $value;
    }

    /**
     * UK sort code for sending and receiving payments, must be within the set
     * of sort codes allocated to the payment business.
     *
     * @param string
     */
    protected function setSortCode($value)
    {
        $this->assertString(
            $value,
            static::SORT_CODE_MIN_LENGTH,
            static::SORT_CODE_MAX_LENGTH,
            '/^\d{6}$/'
        );

        $this->sortCode = $value;
    }

    /**
     * UK sort code for sending and receiving payments, must be within the set
     * of sort codes allocated to the payment business.
     *
     * @param string
     */
    protected function setAccountNumber($value)
    {
        $this->assertString(
            $value,
            static::ACCOUNT_NUMBER_MIN_LENGTH,
            static::ACCOUNT_NUMBER_MAX_LENGTH,
            '/^\d{8}$/'
        );

        $this->accountNumber = $value;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $data = [
            'accountName' => $this->accountName,
            'sortCode' => $this->sortCode,
        ];

        if ($this->accountNumber !== null) {
            $data['accountNumber'] = $this->accountNumber;
        }

        return $data;
    }
}
