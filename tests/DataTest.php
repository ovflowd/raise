<?php

use App\Facades\Test;

class DataTest extends Test
{
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

        $token = response()::response()->token;

        $this->configureRaise(['Content-Type' => 'application/json', 'authorization' => $token],
            'POST', $_SERVER, '/service/register');

        $serviceModel = [
            (object) [
                'clientTime' => microtime(true),
                'tags'       => ['example-tag'],
                'name'       => 'Get temp',
                'parameters' => ['humidity', 'temperature'],
                'returnType' => 'float',
            ],
        ];
        $this->executeRaise($serviceModel);

        $serviceId = response()::response()->services[0]['id'];

        $this->configureRaise(['Content-Type' => 'application/json', 'authorizaion' => $token],
           'POST', $_SERVER, '/data/register');

        $dataModel = [
           (object) [
               'clientTime' => microtime(true),
               'tags'       => ['example-tag'],
               'serviceId'  => $serviceId,
               'order'      => ['humidity', 'temperature'],
               'values'     => [['20.2', '30']],
           ],
       ];

        $this->executeRaise($dataModel);

        $this->assertInstanceOf(\App\Models\Response\Data::class, response()::response());

        $this->assertEquals(200, response()::response()->code);
    }
}
