<?php

namespace Consilience\Starling\Payments\Request\Model;

/**
 * Request for a new address for a payment account.
 */

use PHPUnit\Framework\TestCase;

class CreatePaymentAccountAddressRequestTest extends TestCase
{
    /**
     * Can instantiate a simple object.
     */
    public function testSimple()
    {
        // Minimal limits.

        $createPaymentAccountAddressRequest = new CreatePaymentAccountAddressRequest(
            'a',
            '000000'
        );

        $this->assertTrue($createPaymentAccountAddressRequest instanceof CreatePaymentAccountAddressRequest);

        $this->assertSame('a', $createPaymentAccountAddressRequest->accountName);
        $this->assertSame('000000', $createPaymentAccountAddressRequest->sortCode);

        $this->assertSame(
            '{"accountName":"a","sortCode":"000000"}',
            json_encode($createPaymentAccountAddressRequest)
        );

        // Maximum limits.

        $maxAccountName = str_repeat('Z', 40);

        $createPaymentAccountAddressRequest = new createPaymentAccountAddressRequest(
            $maxAccountName,
            '999999',
            '99999999'
        );

        $this->assertSame($maxAccountName, $createPaymentAccountAddressRequest->accountName);
        $this->assertSame('99999999', $createPaymentAccountAddressRequest->accountNumber);

        $this->assertSame(
            '{"accountName":"ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ","sortCode":"999999","accountNumber":"99999999"}',
            json_encode($createPaymentAccountAddressRequest)
        );

        // Check all characters we expect the accountName to be able to take,
        $createPaymentAccountAddressRequest = new createPaymentAccountAddressRequest(
            'azAZ09-?:().+#=!%&*<>;{@ "\'',
            '999999'
        );
    }

    /**
     * Fail on string limit exceeded.
     *
     * @expectedException UnexpectedValueException
     */
    public function testStringTooLong()
    {
        $maxAccountName = str_repeat('Z', 41);

        $createPaymentAccountAddressRequest = new createPaymentAccountAddressRequest(
            $maxAccountName,
            '555555'
        );
    }

    /**
     * Fail on wrong data type.
     *
     * @expectedException UnexpectedValueException
     */
    public function testStringNotString()
    {
        $createPaymentAccountAddressRequest = new createPaymentAccountAddressRequest(
            123,
            '555555'
        );
    }

    /**
     * Fail on wrong enum valuee.
     *
     * @expectedException UnexpectedValueException
     */
    public function testInvalidAccountNameFormat()
    {
        $createPaymentAccountAddressRequest = new createPaymentAccountAddressRequest(
            'Invalid Name[]',
            '000000'
        );
    }

    /**
     * Fail on wrong enum valuee.
     *
     * @expectedException UnexpectedValueException
     */
    public function testInvalidSortCodeFormat()
    {
        $createPaymentAccountAddressRequest = new createPaymentAccountAddressRequest(
            'Valid Name',
            'ZZZZZZ'
        );
    }
}
