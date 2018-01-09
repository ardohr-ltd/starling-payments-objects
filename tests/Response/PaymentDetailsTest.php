<?php

namespace Consilience\Starling\Payments\Response;

/**
 *
 */

use PHPUnit\Framework\TestCase;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Currencies\ISOCurrencies;
use Money\Money;

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
    public function testFromData(array $paymentDetailsData)
    {
        $paymentDetails = PaymentDetails::fromData($paymentDetailsData);

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

        $paymentDetails = PaymentDetails::fromData($data);

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

        // TODO: requestedAt timestamp with microseconds
        // TODO: fpsSettlementDate simple date
    }
}
