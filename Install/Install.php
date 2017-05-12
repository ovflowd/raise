<?php

function createBucket($details, $credentials)
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

    return communicateCouchbase('pools/default/buckets', $credentials, $bucket);
}

function insertMetadata($details, $connection)
{
    $metadataBucket = $connection->openBucket('metadata');

    $metadataName = uniqid('', true);

    $result = $metadataBucket->insert($metadataName, [
        'codHttp'  => $details->codHttp,
        'codCouch' => $details->codCouch,
        'message'  => $details->message,
    ]);
}

function communicateCouchbase($url, $credentials, $post = null)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_USERPWD, "{$credentials['user']}:{$credentials['senha']}");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_URL, "http://{$credentials['ip']}:8091/{$url}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    if ($post != null) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    }

    $server_output = curl_exec($ch);

    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_close($ch);

    return json_decode($server_output);
}

function checkLibrary()
{
    return class_exists('CouchbaseCluster');
}

function checkVersion()
{
    return PHP_MAJOR_VERSION >= 7;
}

function setCredentials()
{
    echo 'Now we need configure Couchbase Credentials. Follow the questions, please be sure of what you input.'.PHP_EOL;

    echo 'Please input Couchbase Server Address (eg.: 127.0.0.1): ';

    $ip = fgets(STDIN);

    echo PHP_EOL;

    echo 'Please input Couchbase Username (eg.: user): ';

    $user = fgets(STDIN);

    echo PHP_EOL;

    echo 'Please input Couchbase Password (eg.: pass): ';

    $senha = fgets(STDIN);

    echo PHP_EOL;

    return ['ip' => $ip, 'user' => $user, 'senha' => $senha];
}

echo 'Welcome to the RAISe Installer.'.PHP_EOL
    .'<<This Installer will do many checks before continue, be patient.>>'.PHP_EOL;

if (checkVersion()) {
    echo '[OK] php version passed.'.PHP_EOL;
} else {
    echo '[ERROR] Your PHP version isn\'t correct. You need use php 7 or higher. Actually using: '.phpversion().PHP_EOL;

    exit(1);
}

if (checkLibrary()) {
    echo '[OK] Library Checks Passed...'.PHP_EOL;
} else {
    echo '[ERROR] Couchbase Library for PHP isn\'t installed correctly.'.PHP_EOL;

    exit(1);
}

$connectionOK = false;

$credentials = null;

while (!$connectionOK) {
    try {
        $temporaryCredentials = setCredentials();

        $temporaryConnection = (new CouchbaseCluster("{$temporaryCredentials['ip']},{$temporaryCredentials['user']},{$temporaryCredentials['senha']}"));
    } catch (CouchbaseException $e) {
        echo '[ERROR] Your credentials aren\'t correct. Try again please.'.PHP_EOL;
    } finally {
        echo '[OK] Connected Successfully to Couchbase Server.'.PHP_EOL;

        $credentials = $temporaryCredentials;

        $connectionOK = true;
    }
}

$connection = (new CouchbaseCluster("{$credentials['ip']},{$credentials['user']},{$credentials['senha']}"));

$manager = $connection->manager($credentials['user'], $credentials['senha']);

echo 'Now the Buckets will be created. Please wait...'.PHP_EOL;

echo '[WAIT] Getting Information from the Cluster via API....'.PHP_EOL;

$serverInfo = communicateCouchbase('pools/default', $credentials);

$memoryQuota = $serverInfo->memoryQuota;

echo '[INFO] Your Cluster RAM is: '.$memoryQuota.'MB.'.PHP_EOL;

$buckets = ['metadata' => floor((($memoryQuota / 100) * 2.5)),
    'client'           => floor((($memoryQuota / 100) * 17.5)),
    'service'          => floor((($memoryQuota / 100) * 17.5)),
    'token'            => floor((($memoryQuota / 100) * 12.5)),
    'data'             => floor((($memoryQuota / 100) * 25)),
    'response'         => floor((($memoryQuota / 100) * 25)), ];

echo '[INFO] Starting Creation Proccess...'.PHP_EOL;

foreach ($buckets as $bucketName => $bucketMemory) {
    echo '[INFO] Creating Bucket: '.$bucketName.' with '.$bucketMemory.' of memory in MB.'.PHP_EOL;

    createBucket(['name' => $bucketName, 'memory' => $bucketMemory], $credentials);
}

echo 'Starting to Fill Buckets...'.PHP_EOL;

echo 'Filling Client Bucket...'.PHP_EOL;

try {
    $clientBucket = $connection->openBucket('client');

    $clientBucket->manager()->createN1qlPrimaryIndex('', false, false);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Client Bucket!'.PHP_EOL;
}

echo 'Filling Service Bucket...'.PHP_EOL;

try {
    $serviceBucket = $connection->openBucket('service');

    $serviceBucket->manager()->createN1qlPrimaryIndex('', false, false);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Service Bucket!'.PHP_EOL;
}

echo 'Filling Token Bucket...'.PHP_EOL;

try {
    $tokenBucket = $connection->openBucket('token');

    $tokenBucket->manager()->createN1qlPrimaryIndex('', false, false);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Token Bucket!'.PHP_EOL;
}

echo 'Filling Data Bucket...'.PHP_EOL;

try {
    $dataBucket = $connection->openBucket('data');

    $dataBucket->manager()->createN1qlPrimaryIndex('', false, false);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Data Bucket!'.PHP_EOL;
}

echo 'Filling Response Bucket...'.PHP_EOL;

try {
    $responseBucket = $connection->openBucket('response');

    $responseBucket->manager()->createN1qlPrimaryIndex('', false, false);
} catch (CouchbaseException $e) {
    echo '[WARN] Failed to Fill Response Bucket!'.PHP_EOL;
}

echo '[INFO] Filling Metadatas...'.PHP_EOL;

$metadataJson = json_decode(file_get_contents('metadata.json'));

foreach ($metadataJson as $metadata) {
    insertMetadata($metadata, $connection);
}

echo 'Creating Configurationg File...'.PHP_EOL;

$config = <<<CONFIG
<?php

// RAISe Couchbase Configuration

const DB_TYPE = 'COUCHBASE';
const DB_ADDRESS = '{$credentials['ip']},{$credentials['user']},{$credentials['senha']}';
const DB_IP = '{$credentials['ip']}';
const DB_USER = '{$credentials['user']}';
const DB_PASSWORD = '{$credentials['senha']}';
CONFIG;

unlink('../Config/Config.php');
file_put_contents('../Config/Config.php', $config);

echo 'Setup Finished.'.PHP_EOL;
