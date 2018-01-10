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

class ChangeStatusPaymentAccountAddressResponseTest extends TestCase
{
    /**
     * Can instantiate an empty object.
     */
    public function testEmpty()
    {
        $changeStatusPaymentAccountAddressResponse = new ChangeStatusPaymentAccountAddressResponse();

        $this->assertTrue(
            $changeStatusPaymentAccountAddressResponse instanceof ChangeStatusPaymentAccountAddressResponse
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

    /**
     * Can instantiate from a single data record.
     */
    public function testFromArray()
    {
        $changeStatusPaymentAccountAddressResponseData = $this->readDataFile('changeStatusPaymentAccountAddressResponse.json');

        $changeStatusPaymentAccountAddressResponse = ChangeStatusPaymentAccountAddressResponse::fromArray(
            $changeStatusPaymentAccountAddressResponseData
        );

        $this->assertTrue(
            $changeStatusPaymentAccountAddressResponse instanceof ChangeStatusPaymentAccountAddressResponse
        );
        $this->assertTrue($changeStatusPaymentAccountAddressResponse->isSuccess());

        $this->assertSame(1, $changeStatusPaymentAccountAddressResponse->errors->count());
        $this->assertSame(
            'Something about the validation error',
            $changeStatusPaymentAccountAddressResponse->errors->first()->message
        );
    }
}

