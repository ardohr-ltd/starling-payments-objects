<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Details of the payment service business accessing the Starling APIs.
 */

use PHPUnit\Framework\TestCase;

class CreatePaymentAccountRequestTest extends TestCase
{
    /**
     * Can instantiate a simple object.
     */
    public function testSimple()
    {
        // Minimal limits.

        $createPaymentAccountRequest = new CreatePaymentAccountRequest(
            '',
            'AGENCY'
        );

        $this->assertTrue($createPaymentAccountRequest instanceof CreatePaymentAccountRequest);

        $this->assertSame('', $createPaymentAccountRequest->description);
        $this->assertSame('AGENCY', $createPaymentAccountRequest->accountHolder);

        $this->assertSame(
            '{"description":"","accountHolder":"AGENCY"}',
            json_encode($createPaymentAccountRequest)
        );

        // Maximum limits.

        $maxDescription = str_repeat('x', 100);

        $createPaymentAccountRequest = new CreatePaymentAccountRequest(
            $maxDescription,
            'PAYMENT_BUSINESS'
        );

        $this->assertSame($maxDescription, $createPaymentAccountRequest->description);
    }

    /**
     * Fail on string limit exceeded.
     *
     * @expectedException UnexpectedValueException
     */
    public function testStringTooLong()
    {
        $maxDescription = str_repeat('x', 101);

        $createPaymentAccountRequest = new CreatePaymentAccountRequest(
            $maxDescription,
            'PAYMENT_BUSINESS'
        );
    }

    /**
     * Fail on wrong data type.
     *
     * @expectedException UnexpectedValueException
     */
    public function testStringNotString()
    {
        $createPaymentAccountRequest = new CreatePaymentAccountRequest(
            123,
            'PAYMENT_BUSINESS'
        );
    }

    /**
     * Fail on wrong enum valuee.
     *
     * @expectedException UnexpectedValueException
     */
    public function testInvalidEnum()
    {
        $createPaymentAccountRequest = new CreatePaymentAccountRequest(
            'Valid Description',
            'INVALID_ENUM_VALUE'
        );
    }
}
