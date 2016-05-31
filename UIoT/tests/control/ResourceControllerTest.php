<?php

use UIoT\control\ResourceController;
use UIoT\database\DatabaseExecuter;

class ResourceControllerTest extends PHPUnit_Framework_TestCase
{
    public function testCreateDbExecuterClass()
    {
        $resourceController = new ResourceController();
        $this->assertEquals($resourceController->getDbExecuter(), new DatabaseExecuter());
        $this->assertNotEquals($resourceController->getDbExecuter(), new stdClass());
        
    }

    /**
     * @depends testCreateDbConnector
     */
    public function testCreateDbConnector()
    {
        $resourceController = new ResourceController();
        $this->assertEquals($resourceController->getConnection(), new PDO());
        $this->assertEquals($resourceController->getConnection(), new PDO());

    }
    /**
     * @
    */
    public function createMockPDO(){
        
    }



}
