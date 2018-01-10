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

class PaymentOriginatingOverseasInstructionResponseTest extends TestCase
{
    /**
     * Can instantiate an empty object.
     */
    public function testEmpty()
    {
        $paymentOriginatingOverseasInstructionResponse = new PaymentOriginatingOverseasInstructionResponse();

        $this->assertTrue($paymentOriginatingOverseasInstructionResponse instanceof PaymentOriginatingOverseasInstructionResponse);
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
        $paymentOriginatingOverseasInstructionResponseData = $this->readDataFile('paymentOriginatingOverseasInstructionResponse.json');

        $paymentOriginatingOverseasInstructionResponse = PaymentOriginatingOverseasInstructionResponse::fromArray(
            $paymentOriginatingOverseasInstructionResponseData
        );

        $this->assertTrue($paymentOriginatingOverseasInstructionResponse instanceof PaymentOriginatingOverseasInstructionResponse);
        $this->assertTrue($paymentOriginatingOverseasInstructionResponse->isSuccess());

        $this->assertSame(1, $paymentOriginatingOverseasInstructionResponse->errors->count());
        $this->assertSame(
            'Something about the validation error',
            $paymentOriginatingOverseasInstructionResponse->errors->first()->message
        );
    }
}
