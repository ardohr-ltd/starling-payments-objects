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

class CreatePaymentAccountAddressResponseTest extends TestCase
{
    /**
     * Can instantiate an empty object.
     */
    public function testEmpty()
    {
        $createPaymentAccountAddressResponse = new CreatePaymentAccountAddressResponse();

        $this->assertTrue($createPaymentAccountAddressResponse instanceof CreatePaymentAccountAddressResponse);
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
        $createPaymentAccountAddressResponseData = $this->readDataFile('createPaymentAccountAddressResponse.json');

        $createPaymentAccountAddressResponse = CreatePaymentAccountAddressResponse::fromArray(
            $createPaymentAccountAddressResponseData
        );

        $this->assertTrue($createPaymentAccountAddressResponse instanceof CreatePaymentAccountAddressResponse);
        $this->assertTrue($createPaymentAccountAddressResponse->isSuccess());

        $this->assertSame(1, $createPaymentAccountAddressResponse->errors->count());
        $this->assertSame(
            'Something about the validation error',
            $createPaymentAccountAddressResponse->errors->first()->message
        );
    }
}
