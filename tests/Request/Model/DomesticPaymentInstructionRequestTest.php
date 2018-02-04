<?php

namespace Consilience\Starling\Payments\Request\Models;

/**
 *
 */

use PHPUnit\Framework\TestCase;
use Consilience\Starling\Payments\Request\Models\DomesticInstructionAccount;
use Consilience\Starling\Payments\Request\Models\CurrencyAndAmount;

class DomesticPaymentInstructionRequestTest extends TestCase
{
    public function testValid()
    {
        $domesticInstructionAccount = new DomesticInstructionAccount(
            '000000',
            '00000000',
            'AccountName'
        );

        $currencyAndAmount = new CurrencyAndAmount('GBP', 999);

        $model = new DomesticPaymentInstructionRequest(
            $domesticInstructionAccount,
            're/fe#re"nc(e',
            $currencyAndAmount,
            'SIP'
        );
    }
}
