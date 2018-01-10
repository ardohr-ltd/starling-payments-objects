<?php

namespace Consilience\Starling\Payments\Response;

/**
 * Details of the payment service business accessing the Starling APIs.
 */

use PHPUnit\Framework\TestCase;

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
}
