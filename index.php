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
 * @author UIoT
 * @developer Caio Melo
 * @developer Pedro Luiz Salgado
 * @copyright University of Brasília
 */

include_once __DIR__ . '/vendor/autoload.php';

use UIoT\view\RequestInput;

echo json_encode((new RequestInput)->start(), JSON_PRETTY_PRINT);

