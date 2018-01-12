<?php

namespace Consilience\Starling\Payments\ServerRequest;

/**
 *
 */

use PHPUnit\Framework\TestCase;
use Carbon\Carbon;

class AccountTransactionNotificationTest extends TestCase
{
    /**
     * Can instantiate an empty object.
     */
    public function testEmpty()
    {
        $accountTransactionNotification = new AccountTransactionNotification();

        $this->assertTrue($accountTransactionNotification instanceof AccountTransactionNotification);
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
