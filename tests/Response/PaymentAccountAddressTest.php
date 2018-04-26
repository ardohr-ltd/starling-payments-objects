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

class PaymentAccountAddressTest extends TestCase
{
    /**
     * Can instantiate an empty object.
     */
    public function testEmpty()
    {
        $paymentAccountAddress = new PaymentAccountAddress();

        $this->assertTrue($paymentAccountAddress instanceof PaymentAccountAddress);
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
        $paymentAccountAddressData = $this->readDataFile('paymentAccountAddress.json');

        $paymentAccountAddress = PaymentAccountAddress::fromArray($paymentAccountAddressData);

        $this->assertTrue($paymentAccountAddress instanceof PaymentAccountAddress);
        $this->assertSame('2017-06-05T11:47:58.801Z', $paymentAccountAddress->createdAt);
        $this->assertTrue($paymentAccountAddress->createdAtCarbon instanceof Carbon);
        $this->assertSame(
            '2017-06-05T11:47:58+00:00',
            $paymentAccountAddress->createdAtCarbon->toRfc3339String()
        );

        $this->assertTrue($paymentAccountAddress->isActive());

        $this->assertInstanceOf(
            'Consilience\Starling\Payments\Response\Models\AddressFasterPaymentsStatus',
            $paymentAccountAddress->fasterPaymentsStatus
        );
        $this->assertSame(
            $paymentAccountAddress->fasterPaymentsStatus::ADDRESS_FPS_STATUS_ENABLED,
            $paymentAccountAddress->fasterPaymentsStatus->outboundStatus
        );
    }
}
