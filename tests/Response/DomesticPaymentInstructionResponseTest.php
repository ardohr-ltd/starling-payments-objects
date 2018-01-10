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

class DomesticPaymentInstructionResponseTest extends TestCase
{
    /**
     * Can instantiate an empty object.
     */
    public function testEmpty()
    {
        $domesticPaymentInstructionResponse = new DomesticPaymentInstructionResponse();

        $this->assertTrue($domesticPaymentInstructionResponse instanceof DomesticPaymentInstructionResponse);
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
        $domesticPaymentInstructionResponseData = $this->readDataFile('domesticPaymentInstructionResponse.json');

        $domesticPaymentInstructionResponse = DomesticPaymentInstructionResponse::fromArray(
            $domesticPaymentInstructionResponseData
        );

        $this->assertTrue($domesticPaymentInstructionResponse instanceof DomesticPaymentInstructionResponse);
        $this->assertTrue($domesticPaymentInstructionResponse->isSuccess());

        $this->assertSame(1, $domesticPaymentInstructionResponse->errors->count());
        $this->assertSame(
            'Something about the validation error',
            $domesticPaymentInstructionResponse->errors->first()->message
        );
    }
}
