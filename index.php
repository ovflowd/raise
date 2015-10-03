<?php

// this directory
defined('ROOT_REST_DIR') || define('ROOT_REST_DIR', __DIR__);

include_once ROOT_REST_DIR . "/view/requestInput.view.php";

$ri = new RequestInput();
echo $ri->start();