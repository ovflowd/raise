<?php

/**
 * Created by PhpStorm.
 * User: uiot
 * Date: 26/04/16
 * Time: 14:25
 */
class ResourceControllerTest extends PHPUnit_Framework_TestCase
{

    private $resourceController;

    public function ResourceControllerTest(){
        $this->resourceController = new ResourceController();

        $this->createDbExecuterTest();
        
    }

    private function createDbExecuterTest()
    {
        $this->resourceController->createDbExecuter();

        $this->assertEquals($this->resourceController->getDbExecuter(), new DatabaseExecuter());

    }

}
