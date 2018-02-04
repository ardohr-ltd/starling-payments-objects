<?php

namespace Consilience\Starling\Payments\ServerRequest;

/**
 *
 */

use PHPUnit\Framework\TestCase;
use Carbon\Carbon;

class FpsInboundNotificationTest extends TestCase
{
    /**
     * Can instantiate an empty object.
     */
    public function testEmpty()
    {
        $fpsInboundNotification = new FpsInboundNotification();

        $this->assertTrue($fpsInboundNotification instanceof FpsInboundNotification);
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
        $fpsInboundNotificationData = $this->readDataFile('fpsInboundNotification.json');

        $fpsInboundNotification = FpsInboundNotification::fromArray(
            $fpsInboundNotificationData
        );

        $this->assertSame(
            'c58c67d4-bac3-41af-8add-f3e62c2523b0',
            $fpsInboundNotification->settlementCycleUid
        );

        $this->assertSame($fpsInboundNotification::FPS_CYCLE_001, $fpsInboundNotification->fpsSettlementCycleId);
        $this->assertSame('2017-12-05', $fpsInboundNotification->fpsSettlementDate);
        $this->assertTrue($fpsInboundNotification->fpsSettlementDateCarbon instanceof Carbon);

        $this->assertSame(
            '{"fpid":"YMOLZZ8VUN9OTFCAR41020171205826905452     ","paymentBusinessUid":"06a0ab93-4020-0abe-8389-13f82d304df4","paymentAccountUid":"3cc55dfc-93e0-e6b6-4156-35648916427d","addressUid":"1f01c0cf-01a1-483e-97bf-65ce80454478","paymentUid":"06a0ab93-0abe-4020-8389-13f82d304df4","sourceAccount":{"sortCode":"166051","accountNumber":"78899979","accountName":"MR CUSTOMER"},"destinationAccount":{"sortCode":"040057","accountNumber":"52232258","accountName":"MISS CHRISTINE JONES"},"settlementAmount":{"currency":"GBP","minorUnits":45670},"instructedAmount":{"currency":"GBP","minorUnits":45670},"reference":"Test 456","receivedAt":"2017-12-05T10:41:34.000Z","returnDetails":[],"type":"SIP","settlementCycleUid":"c58c67d4-bac3-41af-8add-f3e62c2523b0","fpsSettlementCycleId":"CYCLE_001","fpsSettlementDate":"2017-12-05"}',
            json_encode($fpsInboundNotification)
        );
    }
}
