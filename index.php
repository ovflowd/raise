<?php

/**
 * UIoT Service Layer
 * @version alpha
 *                          88
 *                          ""              ,d
 *                                          88
 *              88       88 88  ,adPPYba, MM88MMM
 *              88       88 88 a8"     "8a  88
 *              88       88 88 8b       d8  88
 *              "8a,   ,a88 88 "8a,   ,a8"  88,
 *               `"YbbdP'Y8 88  `"YbbdP"'   "Y888
 *
 * @author Universal Internet of Things
 * @license MIT <https://opensource.org/licenses/MIT>
 * @copyright University of Brasília
 */

/*  License
    <RAISE is the UIOT's Service Layer
    architecture and environment of the client-side.>
    Copyright (C) <2016>  <University of Brasília>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

use UIoT\Managers\RaiseManager;

if (!file_exists(__DIR__ . '/UIoT/Vendor/autoload.php')) {
    die('<h2>RAISe needs PHP Composer.</h2>Get it through <a href="http://getcomposer.org">here</a>.');
}

/* include settings files */
(require_once __DIR__ . '/UIoT/Vendor/autoload.php');
(require_once __DIR__ . '/UIoT/Settings.php');
(require_once __DIR__ . '/UIoT/Constants.php');

/* start environment */
$manager = (new RaiseManager());


