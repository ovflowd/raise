<?php
use UIoT\messages\EmptyOrNullRowDataValueMessage;

/**
 * Created by PhpStorm.
 * User: uiot
 * Date: 03/05/16
 * Time: 14:34
 */
class DatabaseExecuterTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testExecute()
    {
        $subject = new \UIoT\database\DatabaseManager();

        /**possible expected values of databaseExecuter->execute($x,$x)
         *
         */
        try {
            $finalResult = $subject->execute(null, null);

            assertNotEquals($finalResult, new stdClass());

        } catch (EmptyOrNullRowDataValueMessage $exception) {

        }

    }

}
