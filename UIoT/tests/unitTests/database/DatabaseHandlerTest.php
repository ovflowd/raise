<?php

/**
 * TODO; incomplete
 */
class DatabaseHandlerTest extends PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {

        /*
         * TODO try/catch?
         */
        $databaseHandler = new DatabaseHandler();
        assertEquals(DatabaseProperties::getUser(),$databaseHandler->getUser());
        assertEquals(DatabaseProperties::getPassword(),$databaseHandler->getPassword());
        assertEquals(DatabaseProperties::getName(),$databaseHandler->getName());
        assertEquals(DatabaseProperties::getHost(),$databaseHandler->getHost());
        assertEquals(DatabaseProperties::getType(),$databaseHandler->getType());
        assertEquals(DatabaseProperties::getPort(),$databaseHandler->getPort());

        //assertEquals(XXXXXX,$databaseHandler->getInstance()); Todo verify instance

    }

}
