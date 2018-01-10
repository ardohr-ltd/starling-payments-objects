<?php

namespace Consilience\Starling\Payments\Response;

/**
 *
 */

use PHPUnit\Framework\TestCase;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Currencies\ISOCurrencies;
use Money\Money;
use Carbon\Carbon;

class PaymentAccountTest extends TestCase
{
    /**
     * Can instantiate an empty object.
     */
    public function testEmpty()
    {
        $paymentAccount = new PaymentAccount();

        $this->assertTrue($paymentAccount instanceof PaymentAccount);
    }

    /**
     * Read and return the contents of a test JSON file.
     */
    protected function readDataFile($filename)
    {
        $dataJson = file_get_contents(__DIR__ . '/../data/' . $filename);
        return json_decode($dataJson, true);
    }

    /**
     * Can instantiate from a single data record.
     */
    public function testFromArray()
    {
        $paymentAccountData = $this->readDataFile('paymentAccount.json');

        $paymentAccount = PaymentAccount::fromArray($paymentAccountData);

        $this->assertTrue($paymentAccount instanceof PaymentAccount);
        $this->assertSame('2017-06-05T11:47:58.801Z', $paymentAccount->createdAt);
        $this->assertTrue($paymentAccount->createdAtCarbon instanceof Carbon);
        $this->assertSame('2017-06-05T11:47:58+00:00', $paymentAccount->createdAtCarbon->toRfc3339String());

        $this->assertTrue($paymentAccount->balance->isInCredit());
        $this->assertFalse($paymentAccount->balance->isOverdrawn());
    }
}
