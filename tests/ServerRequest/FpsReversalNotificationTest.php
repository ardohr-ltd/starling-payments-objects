<?php

namespace Consilience\Starling\Payments\ServerRequest;

/**
 *
 */

use PHPUnit\Framework\TestCase;
use Carbon\Carbon;

class FpsReversalNotificationTest extends TestCase
{
    /**
     * Can instantiate an empty object.
     */
    public function testEmpty()
    {
        $fpsReversalNotification = new FpsReversalNotification();

        $this->assertTrue($fpsReversalNotification instanceof FpsReversalNotification);
    }

    /**
     * Read and return the contents of a test JSON file.
     */
    protected function readDataFile($filename)
    {
        $dataJson = file_get_contents(__DIR__ . '/../data/' . $filename);
        return json_decode($dataJson, true);
    }
}
