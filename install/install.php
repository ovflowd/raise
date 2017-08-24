<?php

require_once '../vendor/autoload.php';

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

// Set Time Limit to 0
set_time_limit(0);

// Enable $argv
ini_set('register_argc_argv', true);

// We don't want error reporting during execution of the script
ini_set('display_errors', false);

error_reporting(0);

$options = getopt(null, [
    'user::',
    'pass::',
    'address::',
    'skip-create',
    'skip-fill',
    'skip-configuration',
    'config-schema::',
    'config-file::',
]);

/**
 * Return an Argument Option.
 *
 * @param string $key
 *
 * @return string|null
 */
function option(string $key)
{
    global $options;

    return array_key_exists($key, $options) && is_string($options[$key]) ? $options[$key] : null;
}

/**
 * Create a Configuration File.
 *
 * @param string $fileName
 * @param string $configType
 * @param array  $credentials
 */
function createConfigurationFile(string $fileName, string $configType, array $credentials)
{
    $configurationFile = file_get_contents(__DIR__."/configuration/{$configType}.inc.php");

    $configurationFile = replaceArray([
        '{{ADDRESS}}'  => $credentials['ip'],
        '{{USER}}'     => $credentials['user'],
        '{{PASSWORD}}' => $credentials['pass'],
    ], $configurationFile);

    file_put_contents($fileName, $configurationFile);
}

/**
 * Replace all items from an Array unto a String.
 *
 * @param array  $elements
 * @param string $needle
 *
 * @return mixed|string
 */
function replaceArray(array $elements, string $needle)
{
    foreach ($elements as $oldText => $newText) {
        $needle = str_replace($oldText, $newText, $needle);
    }

    return $needle;
}

/**
 * Create a Bucket on Couchbase.
 *
 * @param array $details
 * @param array $credentials
 *
 * @return mixed
 */
function createBucket(array $details, array $credentials)
{
    $bucket = [
        'authType'      => 'sasl',
        'bucketType'    => 'membase',
        'flushEnabled'  => 0,
        'name'          => $details['name'],
        'ramQuotaMB'    => $details['memory'],
        'replicaIndex'  => 0,
        'replicaNumber' => 1,
        'threadsNumber' => 3,
    ];

    $response = communicateCouchbase('pools/default/buckets', $credentials, $bucket);

    $try = 0;

    while ($response['info']['http_code'] != 202) {
        $response = communicateCouchbase('pools/default/buckets', $credentials, $bucket);

        if (($try++) >= 10) {
            echo writeText("Failed to create Bucket on Couchbase after {$try} times. Aborting.", '41', true);

            return false;
        }
    }

    return $response['info']['http_code'] == 202;
}

/**
 * Insert a Metadata Object on Metadata Table.
 *
 * @param stdClass         $details
 * @param CouchbaseCluster $connection
 */
function insertMetadata(stdClass $details, CouchbaseCluster $connection)
{
    try {
        $metadataBucket = $connection->openBucket('metadata');

        $metadataBucket->insert((string) $details->code, [
            'code'    => $details->code,
            'message' => $details->message,
        ]);
    } catch (Exception $e) {
        echo writeText('Failed to Insert a Metadata.', '1;31', true);

        var_dump($e);
    }
}

/**
 * Communicate with the Couchbase CLI.
 *
 * @param string $url
 * @param array  $credentials
 * @param mixed  $post
 *
 * @return array|object
 */
function communicateCouchbase(string $url, array $credentials, $post = null)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_USERPWD, "{$credentials['user']}:{$credentials['pass']}");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_URL, "http://{$credentials['ip']}:8091/{$url}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    if ($post != null) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    }

    $server_output = curl_exec($ch);

    $info = curl_getinfo($ch);

    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_close($ch);

    return ['body' => json_decode($server_output), 'info' => $info];
}

/**
 * Write Colored Text.
 *
 * @param string $text
 * @param string $color
 * @param bool   $endOfLine
 *
 * @return string
 */
function writeText(string $text, string $color = '0', bool $endOfLine = false)
{
    return "\033[{$color}m{$text}\033[0m ".($endOfLine ? PHP_EOL : '');
}

/**
 * Check if CouchbaseLibrary is installed.
 *
 * @return bool
 */
function checkLibrary()
{
    return class_exists('CouchbaseCluster');
}

/**
 * Check if php is higher or equal than version 7.0.
 *
 * @return bool
 */
function checkVersion()
{
    return PHP_MAJOR_VERSION >= 7;
}

/**
 * Set User Credentials for Couchbase.
 *
 * @return array
 */
function setCredentials()
{
    echo writeText('Now we need configure Couchbase Credentials. Follow the questions, please be sure of what you input.',
        '0;32', true);

    if (option('user') !== null && option('pass') !== null && option('address') !== null) {
        return ['ip' => option('address'), 'user' => option('user'), 'pass' => option('pass')];
    }

    echo 'Please input Couchbase Server Address (eg.: 127.0.0.1): ';

    $ip = str_replace("\n", '', fgets(STDIN));

    echo 'Please input Couchbase Username (eg.: user): ';

    $user = str_replace("\n", '', fgets(STDIN));

    echo 'Please input Couchbase Password (eg.: pass): ';

    $pass = str_replace("\n", '', fgets(STDIN));

    return str_replace(["\n", "\t", "\r"], '', ['ip' => $ip, 'user' => $user, 'pass' => $pass]);
}

/**
 * CLI Progress Bar.
 *
 * @param int    $done
 * @param int    $total
 * @param string $info
 * @param int    $width
 *
 * @return string
 */
function progressBar($done, $total, $info = '', $width = 50)
{
    $percent = round(($done * 100) / $total);
    $bar = round(($width * $percent) / 100);

    return sprintf("%s%%[%s>%s]%s\r", $percent, str_repeat('=', $bar),
        str_repeat(' ', $width - $bar), $info);
}

/*
 * Start the Installer Compomenent
 */

echo PHP_EOL.PHP_EOL;

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

echo PHP_EOL;

$credentials = null;

try {
    $credentials = setCredentials();

    //$authenticator = new \Couchbase\PasswordAuthenticator();
    //$authenticator->username($credentials['user'])->password($credentials['pass']);

    $connection = (new CouchbaseCluster("couchbase://{$credentials['ip']}"));
    //$connection->authenticate($authenticator);
} catch (CouchbaseException $e) {
    echo writeText('Your couchbase credentials are incorrect. Please try again.', '1;31', true);

    exit(1);
} finally {
    echo writeText('Connection to Couchbase Server was successfully established .', '0;32', true);
}

if (option('skip-create') === null) {
    echo writeText('Creating buckets. Please wait...', '0;34', 'true');

    echo PHP_EOL;

    echo writeText('INFO', '46').'Getting Information from the Cluster via API....'.PHP_EOL;

    $serverInfo = communicateCouchbase('pools/default', $credentials)['body'];

    $memoryQuota = $serverInfo->memoryQuota;

    communicateCouchbase('pools/default', $credentials, ['indexMemoryQuota' => ($memoryQuota / 8)]);

    echo writeText('INFO', '46')."Your Cluster RAM size is: {$memoryQuota}MB.".PHP_EOL;

    $buckets = [
        'metadata'   => floor((($memoryQuota / 100) * 10)),
        'client'     => floor((($memoryQuota / 100) * 10)),
        'service'    => floor((($memoryQuota / 100) * 10)),
        'token'      => floor((($memoryQuota / 100) * 10)),
        'data'       => floor((($memoryQuota / 100) * 20)),
        'log'        => floor((($memoryQuota / 100) * 10)),
        'permission' => floor((($memoryQuota / 100) * 5)),
        'profile'    => floor((($memoryQuota / 100) * 5)),
        'relation'   => floor((($memoryQuota / 100) * 10)),
    ];

    echo writeText('INFO', '46').'Starting Creation Process...'.PHP_EOL;

    echo progressBar(0, 7);

    $progress = 1;

    foreach ($buckets as $bucketName => $bucketMemory) {
        echo progressBar($progress++, 7, "Creating Bucket: {$bucketName}.              ");

        sleep(2);

        if (createBucket(['name' => $bucketName, 'memory' => $bucketMemory], $credentials) == false) {
            exit(1);
        }
    }

    echo progressBar(7, 7, 'Buckets Created Successfully.');
}

if (option('skip-fill') === null) {
    $readyToFill = false;

    echo PHP_EOL;

    echo writeText('INFO', '46').'Waiting Buckets to be Ready....'.PHP_EOL;

    $progress = 0;

    while (!$readyToFill) {
        $data = array_filter(communicateCouchbase('pools/default/buckets', $credentials)['body'], function ($bucket) {
            return $bucket->nodes[0]->status != 'healthy';
        });

        if (count($data) == 0) {
            $readyToFill = true;
        }
    }

    echo writeText('INFO', '46').'Starting to Fill Buckets...'.PHP_EOL;

    echo progressBar(0, 6);

    echo progressBar(1, 6, 'Filling Metadata Bucket...                  ');

    try {
        $metadataBucket = $connection->openBucket('metadata');

        $metadataBucket->manager()->createN1qlPrimaryIndex('', false, false);
    } catch (CouchbaseException $e) {
        echo '[WARN] Failed to Fill Metadata Bucket!'.PHP_EOL;
    }

    echo progressBar(2, 6, 'Filling Client Bucket...                  ');

    try {
        $clientBucket = $connection->openBucket('client');

        $clientBucket->manager()->createN1qlPrimaryIndex('', false, false);
    } catch (CouchbaseException $e) {
        echo '[WARN] Failed to Fill Client Bucket!'.PHP_EOL;
    }

    echo progressBar(3, 6, 'Filling Service Bucket...                  ');

    try {
        $serviceBucket = $connection->openBucket('service');

        $serviceBucket->manager()->createN1qlPrimaryIndex('', false, false);
    } catch (CouchbaseException $e) {
        echo '[WARN] Failed to Fill Service Bucket!'.PHP_EOL;
    }

    echo progressBar(4, 6, 'Filling Token Bucket...                  ');

    try {
        $tokenBucket = $connection->openBucket('token');

        $tokenBucket->manager()->createN1qlPrimaryIndex('', false, false);
    } catch (CouchbaseException $e) {
        echo '[WARN] Failed to Fill Token Bucket!'.PHP_EOL;
    }

    echo progressBar(5, 6, 'Filling Data Bucket...                  ');

    try {
        $dataBucket = $connection->openBucket('data');

        $dataBucket->manager()->createN1qlPrimaryIndex('', false, false);
    } catch (CouchbaseException $e) {
        echo '[WARN] Failed to Fill Data Bucket!'.PHP_EOL;
    }

    echo progressBar(6, 6, 'Filling Response Bucket...                  ');

    echo progressBar(6, 6, 'Buckets Filled.                            ');

    echo PHP_EOL;

    try {
        $responseBucket = $connection->openBucket('log');

        $responseBucket->manager()->createN1qlPrimaryIndex('', false, false);
    } catch (CouchbaseException $e) {
        echo '[WARN] Failed to Fill Response Bucket!'.PHP_EOL;
    }

    echo writeText('[INFO]', '46').'Filling Metadata Bucket with Codes.'.PHP_EOL;

    $metadataJson = json_decode(file_get_contents('metadata.json'));

    $progress = 1;

    echo progressBar(0, 60);

    foreach ($metadataJson as $metadata) {
        insertMetadata($metadata, $connection);

        echo progressBar($progress++, 60);
    }

    echo progressBar(60, 60);

    echo PHP_EOL;

    echo writeText('[INFO]', '46').'Creating Basic Permissions.'.PHP_EOL;

    /* CLIENT PERMISSIONS **/

    // Create Client Read Context Permission
    $connection->openBucket('permission')->insert(\App\Facades\Security::generateHash(),
        \App\Facades\Json::map(new \App\Models\Communication\Permission(), ['name' => 'client_read_context', 'description' => 'Read own Context.']));

    // Create Client Write Context Permission
    $connection->openBucket('permission')->insert(\App\Facades\Security::generateHash(),
        \App\Facades\Json::map(new \App\Models\Communication\Permission(), ['name' => 'client_write_context', 'description' => 'Write on own Context.']));

    // Create Client Read Global Permission
    $connection->openBucket('permission')->insert(\App\Facades\Security::generateHash(),
        \App\Facades\Json::map(new \App\Models\Communication\Permission(), ['name' => 'client_read_global', 'description' => 'Read on Global context.']));

    // Create Client Write Global Permission
    $connection->openBucket('permission')->insert(\App\Facades\Security::generateHash(),
        \App\Facades\Json::map(new \App\Models\Communication\Permission(), ['name' => 'client_write_global', 'description' => 'Write on Global context.']));

    /* SERVICE PERMISSIONS **/

    // Create Service Read Context Permission
    $connection->openBucket('permission')->insert(\App\Facades\Security::generateHash(),
        \App\Facades\Json::map(new \App\Models\Communication\Permission(), ['name' => 'service_read_context', 'description' => 'Read own Context.']));

    // Create Service Write Context Permission
    $connection->openBucket('permission')->insert(\App\Facades\Security::generateHash(),
        \App\Facades\Json::map(new \App\Models\Communication\Permission(), ['name' => 'service_write_context', 'description' => 'Write on own Context.']));

    // Create Service Read Global Permission
    $connection->openBucket('permission')->insert(\App\Facades\Security::generateHash(),
        \App\Facades\Json::map(new \App\Models\Communication\Permission(), ['name' => 'service_read_global', 'description' => 'Read on Global context.']));

    // Create Service Write Global Permission
    $connection->openBucket('permission')->insert(\App\Facades\Security::generateHash(),
        \App\Facades\Json::map(new \App\Models\Communication\Permission(), ['name' => 'service_write_global', 'description' => 'Write on Global context.']));

    /* DATA PERMISSIONS **/

    // Create Data Read Context Permission
    $connection->openBucket('permission')->insert(\App\Facades\Security::generateHash(),
        \App\Facades\Json::map(new \App\Models\Communication\Permission(), ['name' => 'data_read_context', 'description' => 'Read own Context.']));

    // Create Data Write Context Permission
    $connection->openBucket('permission')->insert(\App\Facades\Security::generateHash(),
        \App\Facades\Json::map(new \App\Models\Communication\Permission(), ['name' => 'data_write_context', 'description' => 'Write on own Context.']));

    // Create Data Read Global Permission
    $connection->openBucket('permission')->insert(\App\Facades\Security::generateHash(),
        \App\Facades\Json::map(new \App\Models\Communication\Permission(), ['name' => 'data_read_global', 'description' => 'Read on Global context.']));

    // Create Data Write Global Permission
    $connection->openBucket('permission')->insert(\App\Facades\Security::generateHash(),
        \App\Facades\Json::map(new \App\Models\Communication\Permission(), ['name' => 'data_write_global', 'description' => 'Write on Global context.']));

    echo writeText('[INFO]', '46').'Creating Basic Groups.'.PHP_EOL;

    // Create Clients Group
    $connection->openBucket('profile')->insert(\App\Facades\Security::generateHash(),
        \App\Facades\Json::map(new \App\Models\Communication\Profile(),
            ['name' => 'Client', 'uniqueName' => 'client', 'description' => 'The clients Group', 'permissions' => ['client_read_context', 'client_write_context', 'service_read_context', 'service_write_context', 'data_read_context', 'data_write_context']]));

    // Create Administrator Group
    $connection->openBucket('profile')->insert(\App\Facades\Security::generateHash(),
        \App\Facades\Json::map(new \App\Models\Communication\Profile(),
            ['name' => 'Administrator', 'uniqueName' => 'administrator', 'description' => 'The Administrator Group', 'permissions' => ['client_read_global', 'client_write_global', 'service_read_global', 'service_write_global', 'data_read_global', 'data_write_global']]));

    echo writeText('[INFO]', '46').'Creating Administrator Token.'.PHP_EOL;

    $token = bin2hex(openssl_random_pseudo_bytes(20));

    $connection->openBucket('token')->insert();
}

// Configuration File only for Old RAISe
if (option('skip-configuration') === null) {
    echo 'Creating Configuration File...'.PHP_EOL;

    $configurationType = option('config-schema') !== null ? option('config-schema') : 'new';

    $configurationFile = option('config-file') !== null ? option('config-file') : (__DIR__.'/../app/settings.php');

    createConfigurationFile($configurationFile, $configurationType, $credentials);
}

echo "\033[42mSetup Finished.\033[0m".PHP_EOL;
