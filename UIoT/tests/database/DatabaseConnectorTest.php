 <?php

 use UIoT\database\DatabaseConnector;
 use UIoT\properties\DatabaseProperties;

class DatabaseConnectorTest extends PHPUnit_Framework_TestCase{

    /**
     * Tests every property set in __construct() of DatabaseConnector class.
     */
    public function test__construct()
    {
        $databaseConnector = new DatabaseConnector();

        assertEquals( $databaseConnector->getUser() , DB_USER);
        assertEquals( $databaseConnector->getPass() , DB_PASS);
        assertEquals( $databaseConnector->getName() , DB_NAME);
        assertEquals( $databaseConnector->getHost() , DB_HOST);
        assertEquals( $databaseConnector->getType() , DB_TYPE);
        assertEquals( $databaseConnector->getPort() , DB_PORT);

        return $databaseConnector;
    }

    /**
     * @depends test__construct()
     */
    public function setUpDatabaseConnectors(){
        $databaseConnectorArray = Array();
        $databaseConnectorArray->workingCase = new DatabaseConnector();
        //TODO fill an array with various faulty cases and return
    }

    /**
     * TODO verify use of switch in getPdoObject()
     */
    public function testGetPdoObject($databaseConnector){
        $PdoObject = $databaseConnector->getPdoObject();
        assertNotEquals($PdoObject, null);

        //TODO assertEquals($PdoObject, MySqlConnection );

    }

}
