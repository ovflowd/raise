<?php

/*
 *  _    _ _____   _______
 * | |  | |_   _| |__   __|
 * | |  | | | |  ___ | |
 * | |  | | | | / _ \| |
 * | |__| |_| || (_)|| |
 * \_____/|____\____/|_|.
 *
 * @author Universal Internet of Things
 * @license Apache 2 <https://opensource.org/licenses/Apache-2.0>
 * @copyright University of Brasília
 */

echo writeText('Welcome to the RAISe Installer.', '0;31', true);
echo writeText('This Installer will perform various checks before continuing, please be patient.',
    '43', true);

echo PHP_EOL;

if (checkVersion()) {
    echo writeText('OK', '42').'Php version check successful.'.PHP_EOL;
} else {
    echo writeText('ERROR',
            '41')."Your PHP version isn't compatible. Php 7 or higher is needed. Currently Using: ".phpversion().PHP_EOL;

    exit(1);
}

if (checkLibrary()) {
    echo writeText('OK', '42').'Library check successful.'.PHP_EOL;
} else {
    echo writeText('ERROR', '41')."Couchbase Library for PHP isn't installed correctly.".PHP_EOL;

    exit(1);
}
