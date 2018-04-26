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
use GuzzleHttp\Psr7\Response as Psr7Response;

class PaymentAccountCollectionTest extends TestCase
{
    /**
     * Read and return the contents of a test JSON file.
     */
    protected function readDataFile($filename)
    {
        $dataJson = file_get_contents(__DIR__ . '/../data/' . $filename);
        return [
            json_decode($dataJson, true),
        ];
    }

    /**
     * Can instantiate from a single data record.
     */
    public function testFromArray()
    {
        $paymentAccountData = $this->readDataFile('paymentAccount.json');

        $paymentAccountCollection = PaymentAccountCollection::fromArray($paymentAccountData);

        $this->assertSame(1, $paymentAccountCollection->count());

        $paymentAccount = $paymentAccountCollection->first();

        $this->assertTrue($paymentAccount instanceof PaymentAccount);
        $this->assertSame('2017-06-05T11:47:58.801Z', $paymentAccount->createdAt);
        $this->assertTrue($paymentAccount->createdAtCarbon instanceof Carbon);
        $this->assertSame('2017-06-05T11:47:58+00:00', $paymentAccount->createdAtCarbon->toRfc3339String());

        $this->assertTrue($paymentAccount->balance->isInCredit());
        $this->assertFalse($paymentAccount->balance->isOverdrawn());
    }

    /**
     * Can instantiate from a PSR7 message.
     */
    public function testFromPSR7()
    {
        $body = json_encode($this->readDataFile('paymentAccount.json'));

        $paymentAccountResponse = new Psr7Response(
            200,
            [
                'Content-Type' => 'application/json',
            ],
            $body
        );

        $paymentAccountCollection = PaymentAccountCollection::fromResponse($paymentAccountResponse);

        $this->assertSame(1, $paymentAccountCollection->count());

        $paymentAccount = $paymentAccountCollection->first();

        $this->assertTrue($paymentAccount instanceof PaymentAccount);
        $this->assertSame('2017-06-05T11:47:58.801Z', $paymentAccount->createdAt);
        $this->assertTrue($paymentAccount->createdAtCarbon instanceof Carbon);
        $this->assertSame('2017-06-05T11:47:58+00:00', $paymentAccount->createdAtCarbon->toRfc3339String());

        $this->assertTrue($paymentAccount->balance->isInCredit());
        $this->assertFalse($paymentAccount->balance->isOverdrawn());
    }

    /**
     * Can instantiate from a single error response.
     */
    public function testFromPSR7Error()
    {
        $errorResponse = new Psr7Response(
            404,
            [
                //'Content-Type' => 'application/json',
            ],
            ''
        );

        $paymentAccountCollection = PaymentAccountCollection::fromResponse($errorResponse);

        $this->assertSame(0, $paymentAccountCollection->count());

        $this->assertFalse($paymentAccountCollection->isSuccess());
        $this->assertSame(1, $paymentAccountCollection->getErrorCount());

        $this->assertSame(
            '404: Not Found',
            $paymentAccountCollection->getErrors()->first()->message
        );
    }
}
