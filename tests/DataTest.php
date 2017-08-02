<?php

use App\Facades\Test;

class DataTest extends Test
{
    public function testRegister()
    {
        $clientResponse = $this->createClient();

        $serviceResponse = $this->createService($clientResponse->token);

        $dataResponse = $this->createData($serviceResponse->services[0]['id'], $clientResponse->token);

        $this->assertInstanceOf(\App\Models\Response\Data::class, $dataResponse);

        $this->assertEquals(200, $dataResponse->code);
    }
}
