<?php

/**
 *                   .-'''-.
 *                  '   _    \
 *           .--. /   /` '.   \
 *           |__|.   |     \  '
 *           .--.|   '      |  '  .|
 *           |  |\    \     / / .' |_
 *    _    _ |  | `.   ` ..' /.'     |
 *   | '  / ||  |    '-...-'`'--.  .-'
 *  .' | .' ||  |               |  |
 *  /  | /  ||__|               |  |
 * |   `'.  |      UIoT RAISe   |  '.'
 * '   .'|  '/        alpha     |   /
 *  `-'  `--'                   `'-'.
 *
 * @author Universal Internet of Things
 * @license Apache 2 <https://opensource.org/licenses/Apache-2.0>
 * @copyright University of Brasília
 */

// Set Time Limit to 0
set_time_limit(0);

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

        if ($try >= 4) {
            echo writeText("Failed to create Bucket on Couchbase after {$try} times. Aborting.", '41', true);

            return false;
        }

        $try++;
    }

    return $response['body'];
}

/**
 * Insert a Metadata Object on Metadata Table.
 *
 * @param stdClass         $details
 * @param CouchbaseCluster $connection
 */
function insertMetadata(stdClass $details, CouchbaseCluster $connection)
{
    $metadataBucket = $connection->openBucket('metadata');

    $metadataName = uniqid('', true);

    $metadataBucket->insert($metadataName, [
        'codHttp'  => $details->codHttp,
        'codCouch' => $details->codCouch,
        'message'  => $details->message,
    ]);
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
    echo writeText('Now we need configure Couchbase Credentials. Follow the questions, please be sure of what you input.', '0;32', true);

    echo 'Please input Couchbase Server Address (eg.: 127.0.0.1): ';

    $ip = str_replace("\n", '', fgets(STDIN));

    echo 'Please input Couchbase Username (eg.: user): ';

    $user = str_replace("\n", '', fgets(STDIN));

    echo 'Please input Couchbase Password (eg.: pass): ';

    $password = str_replace("\n", '', fgets(STDIN));

    return ['ip' => $ip, 'user' => $user, 'pass' => $password];
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

    return sprintf("%s%%[%s>%s]%s\r", $percent, str_repeat('=', $bar), str_repeat(' ', $width - $bar), $info);
}

echo PHP_EOL.PHP_EOL;

echo writeText('Welcome to the RAISe Installer.', '0;31', true);
echo writeText('This Installer will do many checks before continue, be patient.', '43', true);

echo PHP_EOL;

if (checkVersion()) {
    echo writeText('OK', '42').'php version passed.'.PHP_EOL;
} else {
    echo writeText('ERROR', '41')."Your PHP version isn't correct. You need use php 7 or higher. Actually using: ".phpversion().PHP_EOL;

    exit(1);
}

if (checkLibrary()) {
    echo writeText('OK', '42').'Library Checks Passed...'.PHP_EOL;
} else {
    echo writeText('ERROR', '41')."Couchbase Library for PHP isn't installed correctly.".PHP_EOL;

    exit(1);
}

echo PHP_EOL;

$connectionOK = false;

$credentials = null;

while (!$connectionOK) {
    try {
        $credentials = setCredentials();

        $temporaryConnection = (new CouchbaseCluster("{$credentials['ip']},{$credentials['user']},{$credentials['pass']}"));
    } catch (CouchbaseException $e) {
        echo writeText("Your credentials aren't correct. Try again please.", '1;31', true);
    } finally {
        echo PHP_EOL;

        echo writeText('Connected Successfully to Couchbase Server.', '0;32', true);

        $connectionOK = true;
    }
}

$connection = (new CouchbaseCluster("{$credentials['ip']}"));

echo writeText('Now the Buckets will be created. Please wait...', '0;34', 'true');

echo PHP_EOL;

echo writeText('INFO', '46').'Getting Information from the Cluster via API....'.PHP_EOL;

$serverInfo = communicateCouchbase('pools/default', $credentials)['body'];

$memoryQuota = $serverInfo->memoryQuota;

echo writeText('INFO', '46')."Your Cluster RAM size is: {$memoryQuota}MB.".PHP_EOL;

$buckets = [
    'notcreatable' => 0,
    'metadata'     => floor((($memoryQuota / 100) * 4)),
    'client'       => floor((($memoryQuota / 100) * 12)),
    'service'      => floor((($memoryQuota / 100) * 12)),
    'token'        => floor((($memoryQuota / 100) * 12)),
    'data'         => floor((($memoryQuota / 100) * 20)),
    'response'     => floor((($memoryQuota / 100) * 20)),
];

echo writeText('INFO', '46').'Starting Creation Process...'.PHP_EOL;

echo progressBar(0, 7);

$progress = 1;

foreach ($buckets as $bucketName => $bucketMemory) {
    if ($bucketName != 'notcreatable') {
        echo progressBar($progress++, 7, "Creating Bucket: {$bucketName}.              ");
    }

    sleep(2);

    if (createBucket(['name' => $bucketName, 'memory' => $bucketMemory], $credentials) == false) {
        exit(1);
    }
}

echo progressBar(7, 7, 'Buckets Created Successfully.');

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
    $clientBucket = $connection->openBucket('metadata');

    $clientBucket->manager()->createN1qlPrimaryIndex('', false, false);
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
    $responseBucket = $connection->openBucket('response');

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

echo 'Creating Configuration File...'.PHP_EOL;

$config = <<<CONFIG
<?php

// RAISe Couchbase Configuration

const DB_TYPE = 'COUCHBASE';
const DB_ADDRESS = '{$credentials['ip']},{$credentials['user']},{$credentials['pass']}';
const DB_IP = '{$credentials['ip']}';
const DB_USER = '{$credentials['user']}';
const DB_PASSWORD = '{$credentials['pass']}';

?>
CONFIG;

@unlink('../Config/Config.php');

file_put_contents('../Config/Config.php', $config);

echo "\033[42mSetup Finished.\033[0m".PHP_EOL;
