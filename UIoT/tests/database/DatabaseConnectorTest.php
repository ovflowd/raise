<?php
/**
 * Functions being tested: __construct(), getPdoObject()
 */

use UIoT\database\DatabaseHandler;
use UIoT\properties\DatabaseProperties;

class DatabaseConnectorTest extends PHPUnit_Framework_TestCase
{


    /**
     * Tests every property set in __construct() of DatabaseConnector class.
     */
    public function test__construct()
    {
        $databaseConnector = new DatabaseHandler();

        assertNotEquals($databaseConnector->getUser(), null);
        assertNotEquals($databaseConnector->getPass(), null);
        assertNotEquals($databaseConnector->getName(), null);
        assertNotEquals($databaseConnector->getHost(), null);
        assertNotEquals($databaseConnector->getType(), null);
        assertNotEquals($databaseConnector->getPort(), null);

        assertEquals($databaseConnector->getUser(), DatabaseProperties::DB_USER);
        assertEquals($databaseConnector->getPass(), DatabaseProperties::DB_PASS);
        assertEquals($databaseConnector->getName(), DatabaseProperties::DB_NAME);
        assertEquals($databaseConnector->getHost(), DatabaseProperties::DB_HOST);
        assertEquals($databaseConnector->getType(), DatabaseProperties::DB_TYPE);
        assertEquals($databaseConnector->getPort(), DatabaseProperties::DB_PORT);

        return $databaseConnector;
    }

    /**
     * @depends test__construct()
     * @param $databaseConnector
     * @internal param DatabaseConnectionFailed $exception
     */
    public function testGetPdoObject(DatabaseHandler $databaseConnector)
    {
        $pdo = null;

        try {
            $pdo = $databaseConnector->getInstance();
            assertEquals(get_class($pdo), "");

            //TODO replace empty string with the proper PDO class name
        } catch (\UIoT\messages\DatabaseConnectionFailedMessage $exception) {
            assert(false);
        }

        assertNotEquals($pdo, null);

        //TODO further assert proper functioning of produced PDO;
    }

    /**
     *
     */
    public function setUpDatabaseConnectors()
    {
        $databaseConnectorArray = Array();
        $databaseConnectorArray->workingCase = new DatabaseHandler();
        //TODO fill an array with faulty cases and return;
    }

}
