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

class PaymentDetailsTest extends TestCase
{
    /**
     * Can instantiate an empty object.
     */
    public function testEmpty()
    {
        $paymentDetails = new PaymentDetails();

        $this->assertTrue($paymentDetails instanceof PaymentDetails);
    }

    /**
     * @dataProvider paymentDetailsDataProvider
     *
     * Can instantiate from a single data record.
     */
    public function testFromArray(array $paymentDetailsData)
    {
        $paymentDetails = PaymentDetails::fromArray($paymentDetailsData);

        $this->assertTrue($paymentDetails instanceof PaymentDetails);

        // Now make sure each object can be JSON serialized, then
        // reconstructed, and be unchanged.

        $reconstructed = PaymentDetails::fromArray(
            json_decode(json_encode($paymentDetails), true)
        );

        $this->assertEquals($paymentDetails, $reconstructed);

        $this->assertTrue($reconstructed instanceof PaymentDetails);
    }

    /**
     * Supply a page of 100 payments from a sandbox account.
     * All UUIDs have been replaced with new ones, but otherwise
     * this is data direct from the API.
     */
    public function paymentDetailsDataProvider()
    {
        $dataItems = $this->readDataFile('paymentDetails.json');

        // Each paymentDetail needs to be wrapped in an additional array, so it
        // is treated as a single array parameter for the caller.
        // This is just the way PHPUnit works.

        $data = [];

        foreach($dataItems as $dataItem) {
            $data[] = [$dataItem];
        }

        return $data;
    }

    /**
     * Read and return the contents of a test JSON file.
     */
    protected function readDataFile($filename)
    {
        $dataJson = file_get_contents(__DIR__ . '/../data/' . $filename);
        return json_decode($dataJson, true);
    }

    public function testAccepted()
    {
        $data = $this->readDataFile('paymentDetailsAccepted.json');

        $paymentDetails = PaymentDetails::fromArray($data);

        $money = $paymentDetails->instructedAmount->toMoney();

        $currencies = new ISOCurrencies();
        $moneyFormatter = new DecimalMoneyFormatter($currencies);

        $this->assertTrue($money instanceof Money);
        $this->assertSame('9.99', $moneyFormatter->format($money));
        $this->assertSame('GBP', $money->getCurrency()->getCode());

        $this->assertSame(
            PaymentDetails::DIRECTION_OUTBOUND,
            $paymentDetails->direction
        );
        $this->assertSame(
            PaymentDetails::DIRECTION_OUTBOUND,
            $paymentDetails->getProperty('direction')
        );

        $this->assertSame(true, $paymentDetails->rejectedReason->isEmpty());
        $this->assertSame(false, $paymentDetails->settlementAmount->isEmpty());

        $this->assertTrue($paymentDetails->requestedAtCarbon instanceof Carbon);

        // Make sure we get the micro seconds.
        $this->assertSame(808000, $paymentDetails->requestedAtCarbon->micro);

        $this->assertSame(
            '2018-01-05T16:58:24+00:00',
            $paymentDetails->requestedAtCarbon->timezone('UTC')->toRfc3339String()
        );

        // Dates will be put into the UTC timezone.
        $this->assertSame(
            '2018-01-05T00:00:00+00:00',
            $paymentDetails->fpsSettlementDateCarbon->toRfc3339String()
        );
        $this->assertSame(
            '2018-01-05',
            $paymentDetails->fpsSettlementDateCarbon->toDateString()
        );
    }

    public function testReturned()
    {
        $data = $this->readDataFile('paymentDetailsReturned.json');

        $paymentDetails = PaymentDetails::fromArray($data);

        $this->assertTrue($paymentDetails->isInbound());
        $this->assertFalse($paymentDetails->isOutbound());
        $this->assertTrue($paymentDetails->isAccepted());
        $this->assertFalse($paymentDetails->isRejected());
    }
}
