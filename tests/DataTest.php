<?php

use App\Facades\Test;
/**
 * Created by PhpStorm.
 * User: Faraday
 * Date: 7/30/2017
 * Time: 11:30 PM
 */
class DataTest extends Test
{
    public function testRegister()
    {
        $this->configureRaise(['Content-Type' => 'application/json'], 'POST', $_SERVER, '/client/register');

        $clientModel = (object)[
            'name' => 'Sample Test',
            'chipset' => '0.0',
            'mac' => 'FF:FF:FF:FF:FF',
            'serial' => 'm3t41xR3l02d3d',
            'processor' => 'AMD SUX-K2',
            'channel' => 'ieee-4chan(nel)-802154',
            'location' => '0:0',
            'clientTime' => microtime(true),
        ];

        $this->executeRaise($clientModel);

        $token = response()::response()->token;

        $this->configureRaise(['Content-Type' => 'application/json', 'authorization' => $token],
            'POST', $_SERVER, '/service/register');

        $serviceModel = array(
            (object)[
                'clientTime' => microtime(true),
                'tags' => array('example-tag'),
                'name' => 'Get temp',
                'parameters' => array('humidity', 'temperature'),
                'returnType' => 'float'
            ]
        );
        $this->executeRaise($serviceModel);

       $serviceId = response()::response()->services[0]['id'];

       $this->configureRaise(['Content-Type' => 'application/json', 'authorizaion' => $token],
           'POST', $_SERVER, '/data/register');

       $dataModel = array(
           (object)[
               'clientTime' => microtime(true),
               'tags' => array('example-tag'),
               'serviceId' => $serviceId,
               'order' => array('humidity', 'temperature'),
               'values' => array(array('20.2', '30'))
           ]
       );

       $this->executeRaise($dataModel);

       $this->assertInstanceOf(\App\Models\Response\Data::class, response()::response());

       $this->assertEquals(200, response()::response()->code);
    }
}
