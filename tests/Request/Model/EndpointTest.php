<?php

namespace Consilience\Starling\Payments\Request\Models;

/**
 *
 */

use PHPUnit\Framework\TestCase;

class EndpointTest extends TestCase
{
    public function testValid()
    {
        $endpoint = new Endpoint('07474ac3-ca1c-4407-929f-a980e5f25590');

        // The instance is tje sandbox if not specified otherwise.
        $this->assertSame('sandbox', $endpoint->getProperty('instance'));

        $endpoint = new Endpoint('07474ac3-ca1c-4407-929f-a980e5f25590', 'production');
        $this->assertSame('production', $endpoint->getProperty('instance'));
    }
}
