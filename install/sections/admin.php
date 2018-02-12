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

// Section Administrator Token
echo writeText('[INFO]', '96;1').'Creating Administrator Token.'.PHP_EOL;

// Create Internal Administrator Token
$token = bin2hex(openssl_random_pseudo_bytes(20));

// Create Administrator Client
database()->getConnection()->openBucket('client')->insert($clientId = security()::generateHash(),
    json()::map(new \App\Models\Communication\Client(), [
        'name'      => 'RAISe Engine',
        'chipset'   => 'No Chipset',
        'mac'       => 'No MAC',
        'serial'    => '2.0.0',
        'processor' => 'Software',
        'channel'   => 'RAISe',
        'location'  => 'No Location',
    ]));

// Create Administrator Profile
database()->getConnection()->openBucket('token')->insert($token,
    json()::map(new \App\Models\Communication\Token(), [
        'clientId'   => $clientId,
        'profile'    => 'administrator',
	    'groupId'   => 0
    ]));

// Administrator Hash
$adminHash = json()::encode(setting('security.secretKey'), ['token' => $token]);

echo "Your administration token is: {$token}".PHP_EOL;
echo "Your administration Hash is: {$adminHash}".PHP_EOL;

echo writeText('Important Note. Don\'t lose your Administration Token.'.PHP_EOL.
    'It is important. The hash can be generated again if you loose the token.',
    '93;1', true);
