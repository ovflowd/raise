<?php

/**
 * UIoT Service Layer
 * @version dev-alpha
 *                          88
 *                          ""              ,d
 *                                          88
 *              88       88 88  ,adPPYba, MM88MMM
 *              88       88 88 a8"     "8a  88
 *              88       88 88 8b       d8  88
 *              "8a,   ,a88 88 "8a,   ,a8"  88,
 *               `"YbbdP'Y8 88  `"YbbdP"'   "Y888
 *
 * @project Uniform Internet of Things
 * @app UIoT Service Layer Manager
 *
 * @author UIoT
 * @developer Álex Vidigal
 * @developer Caio Melo
 * @developer Claudio Santoro
 * @developer Lucca Ferri
 * @developer Pedro Luiz Salgado
 *
 * @copyright University of Brasília
 */

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    throw new RuntimeException('UIoT Service Layer Manager requires Composer to run. You can get it <a href="http://gsetcomposer.org">here</a>.');
}

include_once(__DIR__ . '/vendor/autoload.php');

use UIoT\util\JsonOutput;
use UIoT\util\RequestInput;

echo JsonOutput::showJson((new RequestInput)->route());