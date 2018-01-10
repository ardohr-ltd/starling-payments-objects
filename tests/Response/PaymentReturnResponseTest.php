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

class PaymentReturnResponseTest extends TestCase
{
    /**
     * Can instantiate an empty object.
     */
    public function testEmpty()
    {
        $paymentReturnResponse = new PaymentReturnResponse();

        $this->assertTrue($paymentReturnResponse instanceof PaymentReturnResponse);
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
        $paymentReturnResponseData = $this->readDataFile('paymentReturnResponse.json');

        $paymentReturnResponse = PaymentReturnResponse::fromArray(
            $paymentReturnResponseData
        );

        $this->assertTrue($paymentReturnResponse instanceof PaymentReturnResponse);
        $this->assertTrue($paymentReturnResponse->isSuccess());

        $this->assertSame(1, $paymentReturnResponse->errors->count());
        $this->assertSame(
            'Something about the validation error',
            $paymentReturnResponse->errors->first()->message
        );
    }
}
