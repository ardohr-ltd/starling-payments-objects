<?php

namespace Consilience\Starling\Payments\Response;

/**
 *
 */

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Response as Psr7Response;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Currencies\ISOCurrencies;
use Money\Money;
use Carbon\Carbon;

class PaymentDetailsCollectionTest extends TestCase
{
    /**
     * Read and return the contents of a test JSON file.
     */
    protected function readDataFile($filename)
    {
        $dataJson = file_get_contents(__DIR__ . '/../data/' . $filename);
        return $dataJson;
    }

    /**
     * @return void
     * @dataProvider providerFromPSR7
     */
    public function testFromPSR7($contentType)
    {
        $payload = $this->readDataFile('paymentDetailsCollection.json');

        $paymentDetailsCollectionResponse = new Psr7Response(
            200,
            [
                'Content-Type' => $contentType,
            ],
            // Squeeze out the white space.
            json_encode(json_decode($payload))
        );

        $paymentDetailsCollection = PaymentDetailsCollection::fromResponse(
            $paymentDetailsCollectionResponse
        );

        $this->assertSame(100, $paymentDetailsCollection->count());
    }

    public function providerFromPSR7()
    {
        return [
            ['application/json'],
            ['application/json;'],
            ['application/json; utf-8'],
            ['  application/json  ;  utf-8  '],
        ];        
    }
}
