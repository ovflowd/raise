<?php

ini_set('display_errors', 1);
include 'RequestTest.php';

$tester = new RequestTester();

//$tester->testInsertClient(); 
//$tester->testInsertClientwithoutChannel();
//$tester->testListAllClients();
$token = $tester->testAutoRegister(); 
echo '/n'."Testando POST Client Invalido".'/n';
$tester->testInsertClient(false); 
echo '/n'."Testando POST Service Invalido".'/n';
$tester->registerServices($token, false);   
//$tester->registerServices("80ad313c43dbfe095cc5d76c4029f499");