<?php

namespace Consilience\Starling\Payments\Response;

/**
 * Details of the payment service business accessing the Starling APIs.
 */

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Response as Psr7Response;

class BusinessInformationTest extends TestCase
{
    /**
     * Can instantiate an empty object.
     */
    public function testEmpty()
    {
        $businessInformation = new BusinessInformation();

        $this->assertTrue($businessInformation instanceof BusinessInformation);
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
        $businessInformationData = $this->readDataFile('businessInformation.json');

        $businessInformation = BusinessInformation::fromArray(
            $businessInformationData
        );

        $this->assertSame('e2afe359-e73f-4fe1-858a-089e6811d13c', $businessInformation->paymentBusinessUid);
        $this->assertSame('Starling Bank', $businessInformation->name);
        $this->assertSame('GBP', $businessInformation->netSenderCap->currency);
    }

    /**
     * Can instantiate from a single data record.
     */
    public function testFromPSR7()
    {
        $body = '{
            "paymentBusinessUid": "e2afe359-e73f-4fe1-858a-089e6811d13c",
            "name": "Starling Bank",
            "netSenderCap": {
                "currency": "GBP",
                "minorUnits": 12345
            }
        }';
        $businessInformationResponse = new Psr7Response(
            200,
            [
                'Content-Type' => 'application/json',
            ],
            // Squeeze out the white space.
            json_encode(json_decode($body))
        );

        $businessInformation = BusinessInformation::fromResponse(
            $businessInformationResponse
        );

        $this->assertTrue($businessInformation->isSuccess());
        $this->assertSame('e2afe359-e73f-4fe1-858a-089e6811d13c', $businessInformation->paymentBusinessUid);
        $this->assertSame('Starling Bank', $businessInformation->name);
        $this->assertSame('GBP', $businessInformation->netSenderCap->currency);
        $this->assertSame(12345, $businessInformation->netSenderCap->minorUnits);

        $this->assertInstanceOf(
            'Consilience\Starling\Payments\Response\Models\CurrencyAndAmount',
            $businessInformation->netSenderCap
        );
        $this->assertInstanceOf(
            'Money\Money',
            $businessInformation->netSenderCap->toMoney()
        );
    }

    /**
     * Can instantiate from a single data record.
     */
    public function testFromPSR7Error()
    {
        // TODO: get some live example messages to push through the
        // tests rather than constructing what we think they contain.
        // For example, there may be a textual message in the body.

        $businessInformationResponse = new Psr7Response(
            404,
            [
                //'Content-Type' => 'application/json',
            ],
            ''
        );

        $businessInformation = BusinessInformation::fromResponse(
            $businessInformationResponse
        );

        $this->assertFalse($businessInformation->isSuccess());
        $this->assertSame(1, $businessInformation->getErrorCount());

        // 404 "Account not found" in the documaentation, but it's
        // not clear where that message appears.

        $this->assertSame(
            '404: Not Found',
            $businessInformation->getErrors()->first()->message
        );

        $this->assertSame(
            '404: Not Found',
            $businessInformation->getErrors()->first()->getProperty('message')
        );
    }
}
