<?php

use UIoT\control\ResourceController;
use UIoT\database\DatabaseManager;
use TestUtil;

/*
 * TODO incomplete.
 */
class ResourceControllerTest extends PHPUnit_Framework_TestCase
{
    
    public function testConstruct()
    {
        $resourceController = new ResourceController(TestUtil::getResources() , TestUtil::getDatabase() );
        assertEquals($resourceController->getDatabaseManager(),TestUtil::getDatabaseManager() );
        assertEquals($resourceController->getConnection(), TestUtil::getConnection() );

    }

    public function testExecuteRequest()
    {
        //TODO incomplete.
    }



}
