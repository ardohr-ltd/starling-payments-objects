<?php

namespace Consilience\Starling\Payments\ServerRequest;

/**
 *
 */

use PHPUnit\Framework\TestCase;
use Carbon\Carbon;

class FpsRedirectionNotificationTest extends TestCase
{
    /**
     * Can instantiate an empty object.
     */
    public function testEmpty()
    {
        $fpsRedirectionNotification = new FpsRedirectionNotification();

        $this->assertTrue($fpsRedirectionNotification instanceof FpsRedirectionNotification);
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
        $fpsRedirectionNotificationData = $this->readDataFile('fpsRedirectionNotification.json');

        $fpsRedirectionNotification = FpsRedirectionNotification::fromArray(
            $fpsRedirectionNotificationData
        );

        $this->assertSame('efecec3b-69a5-4b8d-b188-b43f98668caf', $fpsRedirectionNotification->notificationUid);
        $this->assertSame('fb0e591d-c903-4298-a18d-d3a066855a40', $fpsRedirectionNotification->paymentUid);
        $this->assertSame(
            '203002',
            $fpsRedirectionNotification->originalAccount->sortCode
        );
        $this->assertSame(
            '99991913',
            $fpsRedirectionNotification->redirectedAccount->accountNumber
        );
        $this->assertSame(
            '{"notificationUid":"efecec3b-69a5-4b8d-b188-b43f98668caf","paymentUid":"fb0e591d-c903-4298-a18d-d3a066855a40","originalAccount":{"accountNumber":"00004588","sortCode":"203002"},"redirectedAccount":{"accountNumber":"99991913","sortCode":"166051"}}',
            json_encode($fpsRedirectionNotification)
        );
    }
}

