<?php

ini_set('display_errors', 1);
include 'RequestTest.php';

$tester = new RequestTester();

//$tester->testInsertClient(); 
//$tester->testInsertClientwithoutChannel();
//$tester->testListAllClients();

$tester->testAutoRegister();
$tester->registerServices("4c9adfb96a364c6805b28f90a342b65c");