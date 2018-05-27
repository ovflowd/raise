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

// Check for the Lock File
if (file_exists(__DIR__ . '/install.lock')) {
    exit(0);
}

// Set Time Limit to 0
set_time_limit(0);

// Enable $argv
ini_set('register_argc_argv', true);

// We don't want error reporting during execution of the script
ini_set('display_errors', true);

// Only Critical Errors
ini_set('error_reporting', (E_ALL ^ (E_NOTICE | E_WARNING)));

/*
 * Start the Installer Component
 */

// Include Installer Functions
require_once __DIR__ . '/functions.php';

// Include Composer Autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Get Couchbase Information
require_once __DIR__ . '/sections/checks.php';

// Include Installer Functions
require_once __DIR__ . '/../app/accessory.php';

$environment = new Dotenv\Dotenv(__DIR__ . '/../');
$environment->load();

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
$authenticator = null;
$credentials = [];
$serverInfo = [];
$memoryQuota = '';
$buckets = [];

// Get Couchbase Credentials
$credentials = setCredentials();

// Initializes the Cluster if an Environment Configuration is Present
if (checkCluster()) {
    echo writeText('Initializing Couchbase Cluster...', '1;31', true);

    if (!createCluster($credentials, getenv('COUCHBASE_BASE_RAM'), getenv('COUCHBASE_INDEX_RAM'))) {
        echo writeText("Failed to Setup Couchbase Cluster. Exiting...", '41', true);

        exit(1);
    }

    echo writeText('Couchbase Cluster Initialized!', '1;31', true);
}

// Tries to Authenticate within Couchbase
try {
    // Create a new Connection
    $connection = new CouchbaseCluster("couchbase://{$credentials['ip']}");

    // Set Credentials
    $authenticator = new \Couchbase\PasswordAuthenticator();
    $authenticator->username($credentials['user']);
    $authenticator->password($credentials['pass']);

    // Try to Authenticate
    $connection->authenticate($authenticator);
} catch (Exception $e) {
    echo writeText('Your couchbase credentials are incorrect. Please try again.', '1;31', true);

    exit(1);
} finally {
    echo writeText('Connection to Couchbase Server was successfully established .', '0;32', true);

    echo PHP_EOL;

    echo 'Creating Configuration File...' . PHP_EOL;

    // Replace Settings File Content
    createConfigurationFile(__DIR__ . '/../app/settings.php', $credentials);

    // Store Settings on Settings Handler
    \App\Handlers\Settings::store(require_once __DIR__ . '/../app/settings.php');

    // Clear Connection variable and Authenticator
    $connection = $authenticator = null;
}

// Section to create the Couchbase Buckets
if (option('skip-create') === null) {
    echo writeText('Creating buckets. Please wait...', '0;34', 'true');

    echo PHP_EOL;

    // Get Couchbase Information
    require_once __DIR__ . '/sections/server.php';

    // Create the Buckets
    require_once __DIR__ . '/sections/buckets.php';
}

// Section to fill the Couchbase Buckets with Indexes and Metadata's
if (option('skip-fill') === null) {
    echo PHP_EOL;

    echo writeText('[INFO]', '96;1') . 'Waiting Buckets to be Ready....' . PHP_EOL;

    $progress = 0;

    // Check if all the buckets are ready to be filled.
    while (true) {
        $data = array_filter(communicateCouchbase('pools/default/buckets', $credentials)['body'], function ($bucket) {
            return $bucket->nodes[0] && $bucket->nodes[0]->status != 'healthy';
        });

        if (count($data) == 0) {
            break;
        }
    }

    // Create Buckets Index Section
    require_once __DIR__ . '/sections/indexes.php';

    // Fill Metadata Bucket Documents
    require_once __DIR__ . '/sections/metadata.php';
}

// Section to create the RAISe Permissions
if (option('skip-permissions') === null) {
    echo PHP_EOL;

    echo writeText('[INFO]', '96;1') . 'Creating Basic Permissions.' . PHP_EOL;

    $permission = database()->getConnection()->openBucket('permission');

    /* CLIENT PERMISSIONS **/
    require_once __DIR__ . '/social/client_permissions.php';

    /* SERVICE PERMISSIONS **/
    require_once __DIR__ . '/social/service_permissions.php';

    /* DATA PERMISSIONS **/
    require_once __DIR__ . '/social/data_permissions.php';
}

// Section to create the RAISe Profiles
if (option('skip-profiles') === null) {
    echo writeText('[INFO]', '96;1') . 'Creating Basic Groups.' . PHP_EOL;

    $profiles = database()->getConnection()->openBucket('profile');

    /* CLIENT PROFILE **/
    require_once __DIR__ . '/social/client_profile.php';

    /* ADMIN PROFILE **/
    require_once __DIR__ . '/social/admin_profile.php';
}

// Create Administrator Account
require_once __DIR__ . '/sections/admin.php';

// Write the Lock File
file_put_contents(__DIR__ . '/install.lock', 'installation-locked');

echo "\033[92;1mSetup Finished.\033[0m" . PHP_EOL;

exit(0);
