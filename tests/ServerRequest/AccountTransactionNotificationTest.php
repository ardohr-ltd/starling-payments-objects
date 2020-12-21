<?php

namespace Consilience\Starling\Payments\ServerRequest;

/**
 *
 */

use PHPUnit\Framework\TestCase;
use Carbon\Carbon;
use Consilience\Starling\Payments\Response\Models\CurrencyAndAmount;

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

    public function testFromArrat()
    {
        $accountTransactionNotificationData = $this->readDataFile('accountTransactionNotificationChaps.json');

        $accountTransactionNotification = AccountTransactionNotification::fromArray(
            $accountTransactionNotificationData
        );

        $this->assertSame(
            '00ba2fea-c545-41f6-9bf9-67cd6267b2e1',
            $accountTransactionNotification->notificationUid
        );

        $this->assertSame(
            '52e6a7f8-513e-4909-8bd6-35c40a37999f',
            $accountTransactionNotification->accountTransactionUid
        );

        $this->assertSame(
            'ffeb4929-5f8e-443e-a406-d87a7a403d0d',
            $accountTransactionNotification->paymentAccountUid
        );

        $this->assertSame(
            AccountTransactionNotification::SOURCE_CHAPS,
            $accountTransactionNotification->source
        );

        $this->assertInstanceOf(CurrencyAndAmount::class, $accountTransactionNotification->currencyAndAmount);

        $this->assertSame(
            'GBP',
            $accountTransactionNotification->currencyAndAmount->currency
        );

        $this->assertSame(
            103,
            $accountTransactionNotification->currencyAndAmount->minorUnits
        );

        $this->assertSame(
            'From CHAPS',
            $accountTransactionNotification->reference
        );
     
        $this->assertSame(
            'From CHAPS',
            $accountTransactionNotification->reference
        );

        $this->assertSame(
            AccountTransactionNotification::DIRECTION_INBOUND,
            $accountTransactionNotification->direction
        );
        
        $this->assertSame(
            '2020-10-15T07:47:53.972Z',
            $accountTransactionNotification->transactionTime
        );
        
        $this->assertInstanceOf(Carbon::class, $accountTransactionNotification->transactionTimeCarbon);
        
        $this->assertSame(
            '123456',
            $accountTransactionNotification->originSortCode
        );

        $this->assertSame(
            '12345678',
            $accountTransactionNotification->originAccountNumber
        );
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
