<?php

ini_set('display_errors', 1);
include 'RequestTest.php';

$tester = new RequestTester();

//$tester->testInsertClient(); 
//$tester->testInsertClientwithoutChannel();
//$tester->testListAllClients();

for ($i = 0; $i < 10; ++$i) {
    $token = $tester->testAutoRegister(); 
    echo '/n'."Testando POST Client Invalido".'/n';
    $tester->testInsertClient(false); 
    echo '/n'."Testando POST Service Invalido".'/n';
    $tester->registerServices($token, false);
    echo $i;
}

//$tester->registerServices("80ad313c43dbfe095cc5d76c4029f499");