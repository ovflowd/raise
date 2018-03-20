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
 * @param array $credentials
 */
function createConfigurationFile(string $fileName, array $credentials)
{
	$configurationFile = file_get_contents(__DIR__ . '/configuration/settings.php');

	$configurationFile = replaceArray([
		'{{ADDRESS}}'  => $credentials['ip'],
		'{{USERNAME}}' => $credentials['user'],
		'{{PASSWORD}}' => $credentials['pass'],
	], $configurationFile);

	file_put_contents($fileName, $configurationFile);
}

/**
 * Replace all items from an Array unto a String.
 *
 * @param array $elements
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
 * @param stdClass $details
 */
function insertMetadata(stdClass $details)
{
	try {
		$metadataBucket = database()->getConnection()->openBucket('metadata');

		$metadataBucket->insert((string)$details->code, [
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
 * @param array $credentials
 * @param mixed $post
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
 * @param bool $endOfLine
 *
 * @return string
 */
function writeText(string $text, string $color = '0', bool $endOfLine = false)
{
	return "\033[{$color}m{$text}\033[0m " . ($endOfLine ? PHP_EOL : '');
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
	if (!empty(getenv('COUCHBASE_HOST')) && !empty(getenv('COUCHBASE_USERNAME')) && !empty(getenv('COUCHBASE_PASSWORD'))) {
		echo writeText('Retrieving Database Configuration from Environment File...', '0;32', true);

		return [
			'ip'   => getenv('COUCHBASE_HOST'),
			'user' => getenv('COUCHBASE_USERNAME'),
			'pass' => getenv('COUCHBASE_PASSWORD')
		];
	}

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
 * @param int $done
 * @param int $total
 * @param string $info
 * @param int $width
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
