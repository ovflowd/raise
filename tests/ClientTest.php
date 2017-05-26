<?php

use Httpful\Request;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientTest.
 */
class ClientTest extends TestCase
{
    /**
     * Test Server URI.
     *
     * @var string
     */
    public $serverUri = 'http://127.0.0.1:8000/';

    /**
     * Test the Client Register.
     *
     * @test
     */
    public function testRegister()
    {
        $clientModel = [
            'name' => 'Sample Test',
            'chipset' => '0.0',
            'mac' => 'FF:FF:FF:FF:FF',
            'serial' => 'm3t41xR3l02d3d',
            'processor' => 'AMD SUX-K2',
            'channel' => 'ieee-4chan(nel)-802154',
            'clientTime' => microtime(true),
        ];

        $response = Request::post($this->serverUri . 'client/register')->sendsJson()->body($clientModel)->send();

        $this->assertNotNull($response);
    }
}
