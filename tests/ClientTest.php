<?php

use App\Facades\Test;

/**
 * Class ClientTest.
 *
 * Executes phpunit test cases
 * for Client Procedures
 *
 * @see \App\Models\Communication\Client
 * @see \App\Models\Response\Client
 * @see \App\Controllers\Client
 */
class ClientTest extends Test
{
    public $testToken;
    /**
     * Test the Client Register.
     *
     * Try to insert a standard client definition
     * and verifies if the response is valid
     *
     * @uses \App\Controllers\Client
     * @uses \App\Models\Response\Client
     *
     * @test
     */
    public function testRegister()
    {
        $this->configureRaise(['Content-Type' => 'application/json'], 'POST', $_SERVER, '/client/register');

        $clientModel = (object) [
            'name'       => 'Sample Test',
            'chipset'    => '0.0',
            'mac'        => 'FF:FF:FF:FF:FF',
            'serial'     => 'm3t41xR3l02d3d',
            'processor'  => 'AMD SUX-K2',
            'channel'    => 'ieee-4chan(nel)-802154',
            'location'   => '0:0',
            'clientTime' => microtime(true),
        ];

        $this->executeRaise($clientModel);

        $this->assertInstanceOf(\App\Models\Response\Token::class, response()::response());

        $this->assertEquals(200, response()::response()->code);
    }
}
