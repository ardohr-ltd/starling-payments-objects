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
    }

    public function paymentDetailsDataProvider()
    {
        $dataJson = file_get_contents(__DIR__ . '/../data/paymentDetails.json');
        $dataItems = json_decode($dataJson, true);

        // Each paymentDetail needs to be wrapped in an additional array, so it
        // is treated as a single array parameter for the caller.

        $data = [];

        foreach($dataItems as $dataItem) {
            $data[] = [$dataItem];
        }

        return $data;
    }

    public function testAccepted()
    {
        // Get all 100 recards.

        $allRecords = $this->paymentDetailsDataProvider();

        // Take just the first.

        $data = $allRecords[0][0];

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
        $this->assertSame(808000, $paymentDetails->requestedAtCarbon->micro);
        $this->assertSame(
            '2018-01-05T16:58:24+00:00',
            $paymentDetails->requestedAtCarbon->timezone('UTC')->toRfc3339String()
        );

        $this->assertSame(
            '2018-01-05T00:00:00+00:00',
            $paymentDetails->fpsSettlementDateCarbon->toRfc3339String()
        );
        $this->assertSame(
            '2018-01-05',
            $paymentDetails->fpsSettlementDateCarbon->toDateString()
        );
    }
}
