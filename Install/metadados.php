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
 *
 * This script will load the error data and documents from the metadata bucket and add the primary index of all buckets.
 * IMPORTANT: this requires the Development PHP for Couchbase extension and yours dependencys to work.
 */

class CouchBaseInterfacer{

	/**
	*Method for insert data message response in metadata bucket.
	*
	*@param string	$code_http	HTTP code.
	*@param string	$code_cb		Couchbase error code.
	*@param	string	$message		Message response.
	*@param string	$cluster		IP Couchbase server.
	*/

	public function metadataInsert(string $cod_http, string $cod_cb, string $message, string $cluster){

		$metadata = uniqId("", true);

		$myCluster = new CouchbaseCluster($cluster);
		$myBucket = $myCluster->openBucket('metadata');
		$result = $myBucket->insert($metadata, array(
			"codHttp"=>$cod_http,
			"codCouch"=>$cod_cb,
			"message"=>$message)
		);
	}

	/**
	*Method for created primary index on all buckets.
	*
	*@param string	$cluster		IP Couchbase server.
	*/

	public function conchBaseInsertKey(string $cluster){

		$myCluster = new CouchbaseCluster($cluster);

		$myBucket = $myCluster->openBucket('client');

		// Before issuing a N1QL Query, ensure that there is
		// is actually a primary index.
		try {
		    // Do not override default name, fail if it is exists already, and wait for completion
		    $myBucket->manager()->createN1qlPrimaryIndex('', false, false);

		} catch (CouchbaseException $e) {
		    printf("Couldn't create index. Maybe it already exists? (code: %d)\n", $e->getCode());
		}

		$myBucket = $myCluster->openBucket('data');

		// Before issuing a N1QL Query, ensure that there is
		// is actually a primary index.
		try {
		    // Do not override default name, fail if it is exists already, and wait for completion
		    $myBucket->manager()->createN1qlPrimaryIndex('', false, false);

		} catch (CouchbaseException $e) {
		    printf("Couldn't create index. Maybe it already exists? (code: %d)\n", $e->getCode());
		}

		$myBucket = $myCluster->openBucket('metadata');
		// Before issuing a N1QL Query, ensure that there is
		// is actually a primary index.
		try {
		    // Do not override default name, fail if it is exists already, and wait for completion
		    $myBucket->manager()->createN1qlPrimaryIndex('', false, false);

		} catch (CouchbaseException $e) {
		    printf("Couldn't create index. Maybe it already exists? (code: %d)\n", $e->getCode());
		}

		$myBucket = $myCluster->openBucket('response');
		// Before issuing a N1QL Query, ensure that there is
		// is actually a primary index.
		try {
		    // Do not override default name, fail if it is exists already, and wait for completion
		    $myBucket->manager()->createN1qlPrimaryIndex('', false, false);

		} catch (CouchbaseException $e) {
		    printf("Couldn't create index. Maybe it already exists? (code: %d)\n", $e->getCode());
		}

		$myBucket = $myCluster->openBucket('token');

		// Before issuing a N1QL Query, ensure that there is
		// is actually a primary index.
		try {
		    // Do not override default name, fail if it is exists already, and wait for completion
		    $myBucket->manager()->createN1qlPrimaryIndex('', false, false);

		} catch (CouchbaseException $e) {
		    printf("Couldn't create index. Maybe it already exists? (code: %d)\n", $e->getCode());
		}

	}

	/**
	*Method for insert documents on metadata bucket.
	*
	*@param string	$cluster		IP Couchbase server.
	*/

	public function metadataInsertDocs(string $cluster)
	{
		$myCluster = new CouchbaseCluster($cluster);

		$myBucket = $myCluster->openBucket('metadata');

		$get_data = "get_data";

		$result = $myBucket->insert($get_data, array(
			"method"=>"get",
			"bucket"=>"data",
			"input"=>[array(
				"code"=> 0,
		  	"tokenId"=>"string",
		  	"start_date"=>"string",
		  	"end_date"=>"string",
		  	"limit"=>"string",
		  	"order"=>"boolean",
		  	"name"=>"string",
		  	"processor"=>"string",
		  	"channel"=>"string",
		  	"host"=>"string",
		  	"tag"=>"string"
		  )],
			"output"=>[array(
				"code"=> 0,
				"values"=>[array(
					"id"=> 0,
					"service"=> "string",
					"value"=> "string"
		  	)]
		  )]
		));

		$post_data = "post_data";

		$result = $myBucket->insert($post_data, array(
			"method"=>"post",
			"bucket"=>"data",
			"input"=>[array(
				"tokenId"=>"string",
				"timestamp"=>"string",
				"services"=>[array(
					"service_id"=> 0,
					"name_service"=> "string",
		  		"params"=> [array(
		      	"name"=> "string",
		      	"type"=> "string"
		      )]
				)]
			)],
			"output"=>[array(
				"code"=> 0,
				"message"=> "string"
			)]
		));

		$get_clients = "get_clients";

		$result = $myBucket->insert($get_clients, array(
			"method"=>"get",
			"bucket"=>"client",
			"input"=>[array(
				"name"=> "string",
			  "processor"=> "string",
			  "channel"=> "double",
			  "host"=> "string",
			  "tag"=> "string"
			)],
			"output"=>[array(
				"code"=> 0,
				"clients"=>[array(
					"name"=>"string",
        	"chipset"=>"string",
		      "mac"=>"string",
        	"serial"=>"string",
        	"processor"=>"string",
        	"channel"=>0
				)]
			)]
		));

		$post_clients = "post_clients";

		$result = $myBucket->insert($post_clients, array(
			"method"=>"post",
			"bucket"=>"client",
			"input"=>[array(
				"name"=> "string",
				"chipset"=> "string",
				"mac"=> "string",
				"serial"=> "string",
				"processor"=> "string",
				"channel"=> 0,
				"timestamp"=> "string"
			)],
			"output"=>[array(
				"code"=> 0,
				"message"=> "string",
				"tokenId"=> "string",
			)]
		));

		$get_service= "get_service";

		$result = $myBucket->insert($get_service, array(
			"method"=>"get",
			"bucket"=>"service",
			"input"=>[array(
				"tokenId"=> "string"
			)],
			"output"=>[array(
				"code"=> 0,
		  	"values"=> [array(
			  	"id"=> 0,
			  	"header_code"=> 0,
			  	"message"=> "string"
				)]
		  )]
  	));

		$post_service= "post_service";

		$result = $myBucket->insert($post_service, array(
			"method"=>"post",
			"bucket"=>"service",
			"input"=>[array(
				"tokenId"=>"string",
				"timestamp"=>"string",
				"services"=>[array(
					"name"=> "string",
		  		"return"=> "string",
		  		"params"=> [array(
		  			"name"=> "string",
		  			"type"=> "string"
		      )]
		   	)]
			)],
			"output"=>[array(
				"code"=>0,
				"services"=>[array(
					"id"=> "string",
		  		"name"=> "string"
		   	)]
			)]
		));

		$get_log= "get_log";

		$result = $myBucket->insert($get_log, array(
			"method"=>"get",
			"bucket"=>"log",
			"input"=>[array(
				"tokenId"=> "string",
		  	"start_date"=>"string",
				"end_date"=>"string",
				"limit"=>"string",
				"order"=>"boolean"
			)],
			"output"=>[array(
				"code"=> 0,
		  	"values"=> [array(
		    	"id"=> 0,
		    	"header_code"=> 0,
		    	"message"=> "string"
		  	)]
		  )]
		));
	}
}

/**
*
*	@var array	$metadosCodHttpCb	Should contain all message response.
*/

$metadosCodHttpCb = array(
	array("codHttp"=> "200",
	"codCouch"=> "00",
	"message"=> "Success"
	),
	array("codHttp"=> "201",
	"codCouch"=> "",
	"message"=> "Created"
	),
	array("codHttp"=> "202",
	"codCouch"=> "",
	"message"=> "Accepted"
	),
	array("codHttp"=> "203",
	"codCouch"=> "",
	"message"=> "Non-Authoritative Information"
	),
	array("codHttp"=> "204",
	"codCouch"=> "",
	"message"=> "No Content"
	),
	array("codHttp"=> "205",
	"codCouch"=> "",
	"message"=> "Reset Content"
	),
	array("codHttp"=> "206",
	"codCouch"=> "",
	"message"=> "Partial Content"
	),
	array("codHttp"=> "207",
	"codCouch"=> "",
	"message"=> "Multi-Status"
	),
	array("codHttp"=> "208",
	"codCouch"=> "00",
	"message"=> "Already Reported"
	),
	array("codHttp"=> "226",
	"codCouch"=> "",
	"message"=> "IM Used"
	),
	array("codHttp"=> "300",
	"codCouch"=> "",
	"message"=> "Multiple Choices"
	),
	array("codHttp"=> "301",
	"codCouch"=> "",
	"message"=> "Moced Permanently"
	),
	array("codHttp"=> "302",
	"codCouch"=> "",
	"message"=> "Found"
	),
	array("codHttp"=> "303",
	"codCouch"=> "",
	"message"=> "See Other"
	),
	array("codHttp"=> "304",
	"codCouch"=> "",
	"message"=> "Not Modified"
	),
	array("codHttp"=> "305",
	"codCouch"=> "",
	"message"=> "Use Proxy"
	),
	array("codHttp"=> "306",
	"codCouch"=> "",
	"message"=> "Swich Proxy"
	),
	array("codHttp"=> "307",
	"codCouch"=> "",
	"message"=> "Temporary Redirect"
	),
	array("codHttp"=> "308",
	"codCouch"=> "",
	"message"=> "Permanent Redirect"
	),
	array("codHttp"=> "400",
	"codCouch"=> "",
	"message"=> "Bad Request"
	),
	array("codHttp"=> "401",
	"codCouch"=> "",
	"message"=> "Unauthorized"
	),
	array("codHttp"=> "402",
	"codCouch"=> "",
	"message"=> "Payment Required"
	),
	array("codHttp"=> "403",
	"codCouch"=> "",
	"message"=> "Forbidden"
	),
	array("codHttp"=> "404",
	"codCouch"=> "",
	"message"=> "Not Found"
	),
	array("codHttp"=> "405",
	"codCouch"=> "",
	"message"=> "Method Not Allowed"
	),
	array("codHttp"=> "406",
	"codCouch"=> "",
	"message"=> "Not acceptable"
	),
	array("codHttp"=> "407",
	"codCouch"=> "",
	"message"=> "Proxy Authentication Required"
	),
	array("codHttp"=> "408",
	"codCouch"=> "",
	"message"=> "Request Timeout"
	),
	array("codHttp"=> "409",
	"codCouch"=> "",
	"message"=> "Conflict"
	),
	array("codHttp"=> "410",
	"codCouch"=> "",
	"message"=> "Gone"
	),
	array("codHttp"=> "411",
	"codCouch"=> "",
	"message"=> "Length Requered"
	),
	array("codHttp"=> "412",
	"codCouch"=> "",
	"message"=> "Precondition Failed"
	),
	array("codHttp"=> "413",
	"codCouch"=> "",
	"message"=> "Payload too Large"
	),
	array("codHttp"=> "414",
	"codCouch"=> "",
	"message"=> "URI too Long"
	),
	array("codHttp"=> "415",
	"codCouch"=> "",
	"message"=> "Unsupported Media Type"
	),
	array("codHttp"=> "416",
	"codCouch"=> "",
	"message"=> "Range Not satisfiable"
	),
	array("codHttp"=> "417",
	"codCouch"=> "01",
	"message"=> "Expectation Failed"
	),
	array("codHttp"=> "418",
	"codCouch"=> "",
	"message"=> "I'm a teapot"
	),
	array("codHttp"=> "421",
	"codCouch"=> "",
	"message"=> "Misdirected Request"
	),
	array("codHttp"=> "422",
	"codCouch"=> "",
	"message"=> "Unprocessable Entity"
	),
	array("codHttp"=> "423",
	"codCouch"=> "",
	"message"=> "Locked"
	),
	array("codHttp"=> "424",
	"codCouch"=> "",
	"message"=> "Failed Dependency"
	),
	array("codHttp"=> "426",
	"codCouch"=> "",
	"message"=> "Upgrade Required"
	),
	array("codHttp"=> "428",
	"codCouch"=> "",
	"message"=> "Precodition Required"
	),
	array("codHttp"=> "429",
	"codCouch"=> "05",
	"message"=> "Too Many Requests"
	),
	array("codHttp"=> "431",
	"codCouch"=> "",
	"message"=> "Request Header Fields Too Large"
	),
	array("codHttp"=> "451",
	"codCouch"=> "",
	"message"=> "Unavailable For Legal Reasons"
	),
	array("codHttp"=> "500",
	"codCouch"=> "06",
	"message"=> "Internal Server Error"
	),
	array("codHttp"=> "501",
	"codCouch"=> "",
	"message"=> "Not Implemented"
	),
	array("codHttp"=> "502",
	"codCouch"=> "",
	"message"=> "Bad Gateway"
	),
	array("codHttp"=> "503",
	"codCouch"=> "08",
	"message"=> "Service Unavailable"
	),
	array("codHttp"=> "504",
	"codCouch"=> "",
	"message"=> "Gateway Timeout"
	),
	array("codHttp"=> "505",
	"codCouch"=> "",
	"message"=> "HTTP version Not supported"
	),
	array("codHttp"=> "506",
	"codCouch"=> "",
	"message"=> "Variant Also Negotiates"
	),
	array("codHttp"=> "507",
	"codCouch"=> "04",
	"message"=> "Insufficient Storage"
	),
	array("codHttp"=> "508",
	"codCouch"=> "",
	"message"=> "loop Detected"
	),
	array("codHttp"=> "510",
	"codCouch"=> "",
	"message"=> "Not Extended"
	),
	array("codHttp"=> "511",
	"codCouch"=> "",
	"message"=> "Network Authentication Required"
	),
	array("codHttp"=> "",
	"codCouch"=> "59",
	"message"=> "Erro Internal")
);

$couchbase = new CouchBaseInterfacer(); //creat a object Couchbase

/**
*
*	@var string	$cluster	Should contain a IP adress couchbase server.
*/
$cluster='127.0.0.1:8091';// enter couchbase ip

$couchbase->conchBaseInsertKey($cluster);

$couchbase->metadataInsertDocs($cluster);

for ($i = 0; $i < count($metadosCodHttpCb); $i++) //
{
	$couchbase->metadataInsert($metadosCodHttpCb[$i]["codHttp"],
															$metadosCodHttpCb[$i]["codCouch"],
															$metadosCodHttpCb[$i]["message"],
															$cluster); //get a message object
}
