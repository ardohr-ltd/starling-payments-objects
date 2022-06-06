<?php

namespace Consilience\Starling\Payments\Request\Models;

/**
 *
 */

use UnexpectedValueException;
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
     */
    public function testStringTooLong()
    {
        $this->expectException(UnexpectedValueException::class);

        $maxDescription = str_repeat('x', 101);

        $createPaymentAccountRequest = new CreatePaymentAccountRequest(
            $maxDescription,
            'PAYMENT_BUSINESS'
        );
    }

    /**
     * Fail on wrong data type.
     */
    public function testStringNotString()
    {
        $this->expectException(UnexpectedValueException::class);

        $createPaymentAccountRequest = new CreatePaymentAccountRequest(
            123,
            'PAYMENT_BUSINESS'
        );
    }

    /**
     * Fail on wrong enum valuee.
     */
    public function testInvalidEnum()
    {
        $this->expectException(UnexpectedValueException::class);

        $createPaymentAccountRequest = new CreatePaymentAccountRequest(
            'Valid Description',
            'INVALID_ENUM_VALUE'
        );
    }
}
