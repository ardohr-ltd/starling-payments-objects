<?php

namespace Consilience\Starling\Payments\Response\Models;

/**
 * Details of the account sending or receiving the payment.
 * The fields specified will vary depending on where the account is based
 * but typically will be a pair of either sortCode & accountNumber, bic &
 * iban or bic & accountNumber.
 */

use Consilience\Starling\Payments\HydratableTrait;

class PaymentDetailsAccount implements \JsonSerializable
{
    use HydratableTrait;

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
     * @var string length 8 to 12 e.g. SRLGGB2L
     * Pattern: [A-Z0-9]{8,12}
     * Business identifier code for the account.
     * This may be present for payments originating overseas.
     */
    protected $bic;

    /**
     * @var string length 4 to 34 e.g. GB29NWBK60161331926819
     * Pattern: [A-Z0-9]{4,34}
     * International bank account number for the account.
     * This may be present for payments originating overseas.
     */
    protected $iban;

    /**
     * @var string length 0 to 40 e.g. Bobby Tables
     * Pattern: [a-zA-Z0-9-/?:().+#=!%&*<>;{@ ”’]{,40}
     * Business identifier code for the account.
     * Name of the account (not always the account holder).
     */
    protected $accountName;
}
