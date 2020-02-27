<?php

namespace Consilience\Starling\Payments\Request\Models;

/**
 * Request for a new payment account.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ValidationTrait;
use Consilience\Starling\Payments\ModelInterface;
use UnexpectedValueException;

class DomesticPaymentInstructionRequest implements ModelInterface
{
    use HydratableTrait;
    use ValidationTrait;

    protected $domesticInstructionAccount;
    protected $reference;
    protected $additionalRemittanceInformation;
    protected $currencyAndAmount;
    protected $string;

    /**
     * @param domesticInstructionAccount $domesticInstructionAccount
     * @param string $reference The reference for the return transaction
     * @param string $reason The reason code; reason for returning
     */
    public function __construct(
        DomesticInstructionAccount $domesticInstructionAccount,
        $reference,
        CurrencyAndAmount $currencyAndAmount,
        $type
    ) {
        $this->setDomesticInstructionAccount($domesticInstructionAccount);
        $this->setReference($reference);
        $this->setCurrencyAndAmount($currencyAndAmount);
        $this->setType($type);
    }

    /**
     * @param DomesticInstructionAccount
     */
    protected function setDomesticInstructionAccount(DomesticInstructionAccount $value)
    {
        $this->domesticInstructionAccount = $value;
    }

    /**
     * The reference for the return transaction.
     *
     * @param string
     */
    protected function setReference($value)
    {
        $this->assertReference($value);

        $this->reference = $value;
    }

    /**
     * The additional remittance information for the return transaction.
     * The optional additionalRemittanceInformation for the return transaction.
     *
     * @param string
     */
    protected function setAdditionalRemittanceInformation($value)
    {
        $this->assertAdditionalRemittanceInformation($value);

        $this->additionalRemittanceInformation = $value;
    }

    /**
     * @param CurrencyAndAmount
     */
    protected function setCurrencyAndAmount(CurrencyAndAmount $value)
    {
        $this->currencyAndAmount = $value;
    }

    /**
     * @param string $value
     */
    protected function setType($value)
    {
        // Validate: SIP, SOP or FDP.
        $this->assertInConstantList('TYPE_DOMESTIC_SIP', $value);

        $this->type = $value;
    }
}
