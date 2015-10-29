<?php

// this directory
defined('ROOT_REST_DIR') || define('ROOT_REST_DIR', __DIR__);

include_once ROOT_REST_DIR . "/view/request_input.view.php";

$ri = new RequestInput();
echo json_encode($ri->start(), JSON_PRETTY_PRINT);

