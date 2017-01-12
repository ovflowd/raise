<?php

ini_set('display_errors', 1);
include 'RequestTest.php';

$tester = new RequestTester();

$tester->testListAllClients();
$tester->testInsertClient();
