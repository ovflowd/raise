<?php

use App\Facades\Test;

class ServiceTest extends Test
{
    public function testRegister()
    {
        $clientResponse = $this->createClient();

        $serviceResponse = $this->createService($clientResponse->token);

        $this->assertInstanceOf(\App\Models\Response\Service::class, $serviceResponse);

        $this->assertEquals(200, $serviceResponse->code);
    }

//    public function testList()
//    {
//        $this->configureRaise(['Content-Type' => 'application/json'], 'POST', $_SERVER, '/client/register');
//
//        $clientModel = (object) [
//            'name'       => 'Samplgit statuse Test',
//            'chipset'    => '0.0',
//            'mac'        => 'FF:FF:FF:FF:FF',
//            'serial'     => 'm3t41xR3l02d3d',
//            'processor'  => 'AMD SUX-K2',
//            'channel'    => 'ieee-4chan(nel)-802154',
//            'location'   => '0:0',
//            'clientTime' => microtime(true),
//        ];
//
//        $this->executeRaise($clientModel);
//
//        $token = response()::response()->token;
//
//        $this->configureRaise(['Content-Type' => 'application/json', 'authorization' => $token],
//            'POST', $_SERVER, '/service/register');
//
//        $serviceModel = [
//            (object) [
//                'clientTime' => microtime(true),
//                'tags'       => ['example-tag'],
//                'name'       => 'Get temp',
//                'parameters' => ['humidity', 'temperature'],
//                'returnType' => 'float',
//            ],
//        ];
//
//        $this->executeRaise($serviceModel);
//
//        $this->configureRaise(['Content-Type' => 'application/json', 'authorization' => $token],
//            'GET', $_SERVER, '/service/');
//
//        $this->executeRaise();
//
//        $this->assertInstanceOf(\App\Models\Communication\Service::class, response()::response()->services[0]);
//
//        $this->assertEquals(200, response()::response()->code);
//    }
//
//    public function testFilter()
//    {
//        //TODO
//
//        $this->assertEquals(true, true);
//    }
}
