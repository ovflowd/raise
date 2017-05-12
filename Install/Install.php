<?php

set_time_limit(0);

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

function write($isOk = true) {
    return ($isOk == true) ? "\033[42m[OK]\033[0m " : "\033[41m[ERROR]\033[0m ";
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

    $ip = str_replace("\n", '', fgets(STDIN));

    echo PHP_EOL;

    echo 'Please input Couchbase Username (eg.: user): ';

    $user = str_replace("\n", '', fgets(STDIN));

    echo PHP_EOL;

    echo 'Please input Couchbase Password (eg.: pass): ';

    $senha = str_replace("\n", '', fgets(STDIN));

    echo PHP_EOL;

    return ['ip' => $ip, 'user' => $user, 'senha' => $senha];
}

echo PHP_EOL . PHP_EOL;

echo "\033[0;31mWelcome to the RAISe Installer.\033[0m".PHP_EOL
    ."\033[43mThis Installer will do many checks before continue, be patient.\033[0m".PHP_EOL;

echo PHP_EOL;

if (checkVersion()) {
    echo write() . 'php version passed.'.PHP_EOL;
} else {
    echo write(0) . 'Your PHP version isn\'t correct. You need use php 7 or higher. Actually using: '.phpversion().PHP_EOL;

    exit(1);
}

if (checkLibrary()) {
    echo write() . 'Library Checks Passed...'.PHP_EOL;
} else {
    echo write(0) . 'Couchbase Library for PHP isn\'t installed correctly.'.PHP_EOL;

    exit(1);
}

$connectionOK = false;

$credentials = null;

while (!$connectionOK) {
    try {
        $temporaryCredentials = setCredentials();

        $temporaryConnection = (new CouchbaseCluster("{$temporaryCredentials['ip']},{$temporaryCredentials['user']},{$temporaryCredentials['senha']}"));
    } catch (CouchbaseException $e) {
        echo write(0) . 'Your credentials aren\'t correct. Try again please.'.PHP_EOL;
    } finally {
        echo write() . 'Connected Successfully to Couchbase Server.'.PHP_EOL;

        $credentials = $temporaryCredentials;

        $connectionOK = true;
    }
}

$connection = (new CouchbaseCluster("{$credentials['ip']}"));

echo 'Now the Buckets will be created. Please wait...'.PHP_EOL;

echo '[WAIT] Getting Information from the Cluster via API....'.PHP_EOL;

$serverInfo = communicateCouchbase('pools/default', $credentials);

$memoryQuota = $serverInfo->memoryQuota;

echo '[INFO] Your Cluster RAM is: '.$memoryQuota.'MB.'.PHP_EOL;

$buckets = [
    'notcreatable'     => 0,
    'metadata'         => floor((($memoryQuota / 100) * 4)),
    'client'           => floor((($memoryQuota / 100) * 12)),
    'service'          => floor((($memoryQuota / 100) * 12)),
    'token'            => floor((($memoryQuota / 100) * 12)),
    'data'             => floor((($memoryQuota / 100) * 20)),
    'response'         => floor((($memoryQuota / 100) * 20))
];

echo '[INFO] Starting Creation Proccess...'.PHP_EOL;

foreach ($buckets as $bucketName => $bucketMemory) {
    echo '[INFO] Creating Bucket: '.$bucketName.' with '.$bucketMemory.' of memory in MB.'.PHP_EOL;

    createBucket(['name' => $bucketName, 'memory' => $bucketMemory], $credentials);
}

$readyToFill = false;

echo '[INFO] Waiting Buckets to be Ready'.PHP_EOL;

while(!$readyToFill) {
    $data = communicateCouchbase('pools/default/buckets', $credentials);

    $data = array_filter($data, function($bucket) {
	return $bucket->nodes[0]->status != 'healthy';
    });

    if(count($data) == 0) {
	$readyToFill = true;
    }
}

echo 'Starting to Fill Buckets...'.PHP_EOL;

echo 'Filling Metadata Bucket...'.PHP_EOL;

try {
    $clientBucket = $connection->openBucket('metadata');

    $clientBucket->manager()->createN1qlPrimaryIndex('', false, false);
} catch (CouchbaseException $e) {

    echo '[WARN] Failed to Fill Metada Bucket!'.PHP_EOL;
}

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

?>
CONFIG;

@unlink('../Config/Config.php');
file_put_contents('../Config/Config.php', $config);

echo "\033[42mSetup Finished.\033[0m".PHP_EOL;
