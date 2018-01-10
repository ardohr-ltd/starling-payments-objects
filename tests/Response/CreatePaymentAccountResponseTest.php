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

class CreatePaymentAccountResponseTest extends TestCase
{
    /**
     * Can instantiate an empty object.
     */
    public function testEmpty()
    {
        $createPaymentAccountResponse = new CreatePaymentAccountResponse();

        $this->assertTrue($createPaymentAccountResponse instanceof CreatePaymentAccountResponse);
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
        $createPaymentAccountResponseData = $this->readDataFile('createPaymentAccountResponse.json');

        $createPaymentAccountResponse = CreatePaymentAccountResponse::fromArray(
            $createPaymentAccountResponseData
        );

        $this->assertTrue($createPaymentAccountResponse instanceof CreatePaymentAccountResponse);
        $this->assertTrue($createPaymentAccountResponse->isSuccess());

        $this->assertSame(1, $createPaymentAccountResponse->errors->count());
        $this->assertSame(
            'Something about the validation error',
            $createPaymentAccountResponse->errors->first()->message
        );
    }
}
