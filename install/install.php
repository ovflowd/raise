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

// Set Time Limit to 0
set_time_limit(0);

// Enable $argv
ini_set('register_argc_argv', true);

// We don't want error reporting during execution of the script
ini_set('display_errors', false);

// Disable Error Reporting
error_reporting(0);

// Include Composer Autoloader
require_once __DIR__.'/../vendor/autoload.php';

// Include Installer Functions
require_once __DIR__.'/../app/accessory.php';

// Include Installer Functions
require_once __DIR__.'/functions.php';

// Gather Application Settings
\App\Handlers\Settings::store(require_once __DIR__.'/configuration/settings.php');

// Available Options
$options = getopt(null, [
    'user::',
    'pass::',
    'address::',
    'skip-create',
    'skip-fill',
    'skip-permissions',
    'skip-profiles',
    'skip-configuration',
    'config-schema::',
    'config-file::',
]);

// Create all future defined variables
$connection = null;
$credentials = [];
$serverInfo = [];
$memoryQuota = '';
$buckets = [];

/*
 * Start the Installer Component
 */

echo PHP_EOL.PHP_EOL;

// Get Couchbase Information
require_once __DIR__.'/sections/checks.php';

echo PHP_EOL;

try {
    // Get User Credentials
    $credentials = setCredentials();

    // Create a new Connection
    $connection = new CouchbaseCluster("couchbase://{$credentials['ip']}");

    // Set Credentials
    $authenticator = new \Couchbase\ClassicAuthenticator();
    $authenticator->cluster($credentials['user'], $credentials['pass']);

    // Try to Authenticate
    $connection->authenticate($authenticator);
} catch (CouchbaseException $e) {
    echo writeText('Your couchbase credentials are incorrect. Please try again.', '1;31', true);

    exit(1);
} finally {
    echo writeText('Connection to Couchbase Server was successfully established .', '0;32', true);
}

// Section to create the Couchbase Buckets
if (option('skip-create') === null) {
    echo writeText('Creating buckets. Please wait...', '0;34', 'true');

    echo PHP_EOL;

    // Get Couchbase Information
    require_once __DIR__.'/sections/server.php';

    // Create the Buckets
    require_once __DIR__.'/sections/buckets.php';
}

// Section to fill the Couchbase Buckets with Indexes and Metadata's
if (option('skip-fill') === null) {
    echo PHP_EOL;

    echo writeText('INFO', '46').'Waiting Buckets to be Ready....'.PHP_EOL;

    $progress = 0;

    // Check if all the buckets are ready to be filled.
    while (true) {
        $data = array_filter(communicateCouchbase('pools/default/buckets', $credentials)['body'], function ($bucket) {
            return $bucket->nodes[0]->status != 'healthy';
        });

        if (count($data) == 0) {
            break;
        }
    }

    // Create Buckets Index Section
    require_once __DIR__.'/sections/indexes.php';

    // Fill Metadata Bucket Documents
    require_once __DIR__.'/sections/metadata.php';
}

// Section to create the RAISe Permissions
if (option('skip-permissions') === null) {
    echo PHP_EOL;

    echo writeText('[INFO]', '46').'Creating Basic Permissions.'.PHP_EOL;

    $permission = $connection->openBucket('permission');

    /* CLIENT PERMISSIONS **/
    require_once __DIR__.'/social/client_permissions.php';

    /* SERVICE PERMISSIONS **/
    require_once __DIR__.'/social/service_permissions.php';

    /* DATA PERMISSIONS **/
    require_once __DIR__.'/social/data_permissions.php';
}

// Section to create the RAISe Profiles
if (option('skip-profiles') === null) {
    echo PHP_EOL;

    echo writeText('[INFO]', '46').'Creating Basic Groups.'.PHP_EOL;

    $profiles = $connection->openBucket('profile');

    /* CLIENT PROFILE **/
    require_once __DIR__.'/social/client_profile.php';

    /* ADMIN PROFILE **/
    require_once __DIR__.'/social/admin_profile.php';
}

// Create Administrator Account
require_once __DIR__.'/sections/admin.php';

// Configuration File only for Old RAISe
if (option('skip-configuration') === null) {
    echo PHP_EOL;

    echo 'Creating Configuration File...'.PHP_EOL;

    $configurationType = option('config-schema') !== null ? option('config-schema') : 'settings';

    $configurationFile = option('config-file') !== null ? option('config-file') : (__DIR__.'/../app/settings.php');

    createConfigurationFile($configurationFile, $configurationType, $credentials);
}

echo "\033[42mSetup Finished.\033[0m".PHP_EOL;
