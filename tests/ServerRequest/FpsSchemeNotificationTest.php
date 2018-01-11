<?php

namespace Consilience\Starling\Payments\ServerRequest;

/**
 *
 */

use PHPUnit\Framework\TestCase;
use Carbon\Carbon;

class FpsSchemeNotificationTest extends TestCase
{
    /**
     * Can instantiate an empty object.
     */
    public function testEmpty()
    {
        $fpsSchemeNotification = new FpsSchemeNotification();

        $this->assertTrue($fpsSchemeNotification instanceof FpsSchemeNotification);
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
        $fpsSchemeNotificationData = $this->readDataFile('fpsSchemeNotificationAccepted.json');

        $fpsSchemeNotification = FpsSchemeNotification::fromArray(
            $fpsSchemeNotificationData
        );

        $this->assertSame('13124d5e-f847-4cd6-bf46-6511c9c850d5', $fpsSchemeNotification->settlementCycleUid);
        $this->assertSame('ACCEPTED', $fpsSchemeNotification->paymentState);
        $this->assertSame('2018-01-05', $fpsSchemeNotification->settlementDate);
        $this->assertTrue($fpsSchemeNotification->settlementDateCarbon instanceof Carbon);
    }
}
