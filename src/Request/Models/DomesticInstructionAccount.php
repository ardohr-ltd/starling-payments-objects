<?php

namespace Consilience\Starling\Payments\Request\Models;

/**
 * Details of the account sending or receiving the payment.
 * The fields specified will vary depending on where the account is based
 * but typically will be a pair of either sortCode & accountNumber, bic &
 * iban or bic & accountNumber.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ValidationTrait;
use Consilience\Starling\Payments\ModelInterface;

class DomesticInstructionAccount implements ModelInterface
{
    use HydratableTrait;
    use ValidationTrait;

    /**
     * @var string length 6 e.g. 040050
     * Sort code for the account. Will only be specified for accounts in the UK.
     */
    protected $sortCode;

    /**
     * @var string length 0 to 34 e.g. 12345678
     * Pattern: [a-zA-Z0-9-/?:().+#=!%&*<>;{@ ”’]{,34}
     * Account number for the account. This will be the UK account number for UK
     * based accounts, it may also contain foreign account numbers for payments
     * originating overseas such as the USA.
     */
    protected $accountNumber;

    /**
     * @var string length 0 to 40 e.g. Bobby Tables
     * Pattern: [a-zA-Z0-9-/?:().+#=!%&*<>;{@ ”’]{,40}
     * Business identifier code for the account.
     * Name of the account (not always the account holder).
     */
    protected $accountName;

    /**
     * @param string $paymentUid The paymentUid being returned
     * @param string $reference The reference for the return transaction
     * @param string $reason The reason code; reason for returning
     */
    public function __construct($sortCode, $accountNumber, $accountName)
    {
        $this->setSortCode($sortCode);
        $this->setAccountNumber($accountNumber);
        $this->setAccountName($accountName);
    }

    /**
     * @param string
     */
    protected function setSortCode($value)
    {
        $this->sortCode = $value;
    }

    /**
     * @param string
     */
    protected function setAccountNumber($value)
    {
        $this->accountNumber = $value;
    }

    /**
     * @param string
     */
    protected function setAccountName($value)
    {
        $this->accountName = $value;
    }
}
