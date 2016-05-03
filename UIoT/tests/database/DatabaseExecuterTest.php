<?php

/**
 * Created by PhpStorm.
 * User: uiot
 * Date: 03/05/16
 * Time: 14:34
 */
class DatabaseExecuterTest extends PHPUnit_Framework_TestCase
{
    
    public function testExecute(){
        $subject = new \UIoT\database\DatabaseExecuter();
        
        /**possible expected values of databaseExecuter->execute($x,$x)
         * 
         */
        try {
            $finalResult = $subject->execute(null, null);
            
            assertNotEquals( $finalResult , new stdClass() );
            
        }catch (EmtyOrNullRowDataValueException $exception){
            
        }
        
    }

}
