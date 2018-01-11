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

class SettlementCycleTest extends TestCase
{
    /**
     * Can instantiate an empty object.
     */
    public function testEmpty()
    {
        $settlementCycle = new SettlementCycle();

        $this->assertTrue($settlementCycle instanceof SettlementCycle);
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
        $settlementCycleData = $this->readDataFile('settlementCycle.json');

        $settlementCycle = SettlementCycle::fromArray($settlementCycleData);

        $this->assertTrue($settlementCycle instanceof SettlementCycle);
        $this->assertSame(11223344, $settlementCycle->netPayment->minorUnits);
        $this->assertSame('OUTBOUND', $settlementCycle->netDirection);

        $this->assertTrue($settlementCycle->startTimeCarbon instanceof Carbon);
        $this->assertTrue($settlementCycle->endTimeCarbon instanceof Carbon);
        $this->assertSame('2017-06-10T07:00:00+00:00', $settlementCycle->startTimeCarbon->toRfc3339String());
        $this->assertSame('2017-06-10T12:59:59+00:00', $settlementCycle->endTimeCarbon->toRfc3339String());
    }
}
