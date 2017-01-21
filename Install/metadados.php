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
 * This script will install all the required couchbase buckets that RAISe needs to work properly.
 * IMPORTANT: this requires the cURL extension to work.
 */

class CouchBaseInterfacer{

	public function metadataInsert(string $cod_http, string $cod_cb, string $message){

		$metadata = uniqId("", true);

		$myCluster = new CouchbaseCluster('127.0.0.1:8091');
		$myBucket = $myCluster->openBucket('metadata');
		$result = $myBucket->insert($metadata, array(
			"codHttp"=>$cod_http,
			"codCouch"=>$cod_cb,
			"message"=>$message)
		);
	}

	public function conchBaseInsertKey(string $cluster){

		$myCluster = new CouchbaseCluster($cluster);

		$myBucket = $myCluster->openBucket('client');

		echo "Creating primary index client\n";
		// Before issuing a N1QL Query, ensure that there is
		// is actually a primary index.
		try {
		    // Do not override default name, fail if it is exists already, and wait for completion
		    $myBucket->manager()->createN1qlPrimaryIndex('', false, false);
		    echo "Primary index has been created\n";
		} catch (CouchbaseException $e) {
		    printf("Couldn't create index. Maybe it already exists? (code: %d)\n", $e->getCode());
		}

		$myBucket = $myCluster->openBucket('data');

		echo "Creating primary index data\n";
		// Before issuing a N1QL Query, ensure that there is
		// is actually a primary index.
		try {
		    // Do not override default name, fail if it is exists already, and wait for completion
		    $myBucket->manager()->createN1qlPrimaryIndex('', false, false);
		    echo "Primary index has been created\n";
		} catch (CouchbaseException $e) {
		    printf("Couldn't create index. Maybe it already exists? (code: %d)\n", $e->getCode());
		}

		$myBucket = $myCluster->openBucket('metadata');

		echo "Creating primary index metadata\n";
		// Before issuing a N1QL Query, ensure that there is
		// is actually a primary index.
		try {
		    // Do not override default name, fail if it is exists already, and wait for completion
		    $myBucket->manager()->createN1qlPrimaryIndex('', false, false);
		    echo "Primary index has been created\n";
		} catch (CouchbaseException $e) {
		    printf("Couldn't create index. Maybe it already exists? (code: %d)\n", $e->getCode());
		}


		$myBucket = $myCluster->openBucket('response');

		echo "Creating primary index response\n";
		// Before issuing a N1QL Query, ensure that there is
		// is actually a primary index.
		try {
		    // Do not override default name, fail if it is exists already, and wait for completion
		    $myBucket->manager()->createN1qlPrimaryIndex('', false, false);
		    echo "Primary index has been created\n";
		} catch (CouchbaseException $e) {
		    printf("Couldn't create index. Maybe it already exists? (code: %d)\n", $e->getCode());
		}

		$myBucket = $myCluster->openBucket('service');

		echo "Creating primary index service\n";
		// Before issuing a N1QL Query, ensure that there is
		// is actually a primary index.
		try {
		    // Do not override default name, fail if it is exists already, and wait for completion
		    $myBucket->manager()->createN1qlPrimaryIndex('', false, false);
		    echo "Primary index has been created\n";
		} catch (CouchbaseException $e) {
		    printf("Couldn't create index. Maybe it already exists? (code: %d)\n", $e->getCode());
		}

		$myBucket = $myCluster->openBucket('token');

		echo "Creating primary index token\n";
		// Before issuing a N1QL Query, ensure that there is
		// is actually a primary index.
		try {
		    // Do not override default name, fail if it is exists already, and wait for completion
		    $myBucket->manager()->createN1qlPrimaryIndex('', false, false);
		    echo "Primary index has been created\n";
		} catch (CouchbaseException $e) {
		    printf("Couldn't create index. Maybe it already exists? (code: %d)\n", $e->getCode());
		}

	}

	public function metadataInsertDocs(string $cluster){

		$myCluster = new CouchbaseCluster($cluster);

		$myBucket = $myCluster->openBucket('metadata');

		$get_clients_list_response = "get_clients_list_response";

		$result = $myBucket->insert($get_clients_list_response, array(
				"docNme"=>$get_clients_list_response,
				"bucket"=>"response",
				"docValues"=>[array(
						"code"=> 0,
						"clients"=> [array(
						    "name"=> "string",
						    "chipset"=> "string",
						    "mac"=> "string",
						    "serial"=> "string",
						    "processor"=> "string",
						    "channel"=> 0
					    )]
					)]

			)
		);

		$get_clients_list_required = "get_clients_list_required";

		$result = $myBucket->insert($get_clients_list_required, array(
				"docNme"=>$get_clients_list_required,
				"bucket"=>"client",
				"docValues"=>[array(
					"name"=> "string",
				    "processor"=> "string",
				    "channel"=> "double",
				    "host"=> "string",
				    "tag"=> "string"
				)]
		    )
		);

		$post_clients_register_required = "post_clients_register_required";

		$result = $myBucket->insert($post_clients_register_required, array(
				"docNme"=>$post_clients_register_required,
				"bucket"=>"client",
				"docValues"=>[array(
					"name"=> "string",
					"chipset"=> "string",
				    "mac"=> "string",
				    "serial"=> "string",
				    "processor"=> "string",
				    "channel"=> 0
				)]
		    )
		);

		$post_clients_register_required = "post_clients_token_register_required";

		$result = $myBucket->insert($post_clients_register_required, array(
				"docNme"=>$post_clients_register_required,
				"bucket"=>"token",
				"docValues"=>[array(
					"name"=> "string",
					"chipset"=> "string",
				    "mac"=> "string",
				    "serial"=> "string",
				    "processor"=> "string",
				    "channel"=> 0,
						"token"=>"string"
				)]
		    )
		);

		$post_client_register_response = "post_client_register_response";

		$result = $myBucket->insert($post_client_register_response, array(
				"docNme"=>$post_client_register_response,
				"bucket"=>"response",
				"docValues"=>[array(
					"code"=> 0,
		  			"message"=> "string",
		  			"token"=> "string"
		  		)]
  			)
		);

		$post_client_register_response = "post_token_register_response";

		$result = $myBucket->insert($post_client_register_response, array(
				"docNme"=>$post_client_register_response,
				"bucket"=>"response",
				"docValues"=>[array(
					"code"=> 0,
		  			"message"=> "string",
		  			"token"=> "string"
		  		)]
  			)
		);

		$get_client_service_values_required = "get_client_service_values_required";

		$result = $myBucket->insert($get_client_service_values_required, array(
				"docNme"=>$get_client_service_values_required,
				"bucket"=>"service",
				"docValues"=>[array(
					"code"=> 0,
		  			"token"=>"string",
		  			"start_date"=>"string",
		  			"end_date"=>"string",
		  			"limit"=>"string",
		  			"order"=>"boolean",
		  			"name"=>"string",
		  			"processor"=>"string",
		  			"channel"=>"string",
		  			"host"=>"string",
		  			"tag"=>"string"
		  		)]
  			)
		);

		$get_client_service_values_response = "get_client_service_values_response";

		$result = $myBucket->insert($get_client_service_values_response, array(
				"docNme"=>$get_client_service_values_response,
				"bucket"=>"response",
				"docValues"=>[array(
					"code"=> 0,
		  			"values"=>[array(
		      			"id"=> 0,
		      			"service"=> "string",
		      			"value"=> "string"
	      			)]
	      		)]
  			)
		);

		$post_service_register_require = "post_service_register_require";

		$result = $myBucket->insert($post_service_register_require, array(
				"docNme"=>$post_service_register_require,
				"bucket"=>"service",
				"docValues"=>[array(
					"token"=>"string",
					"services"=>[array(
						"name"=> "string",
		    			"return"=> "string",
		    			"params"=> [array(
		       				"name"=> "string",
		        			"type"=> "string"
		        		)]
		   			)]
				)]
			)
		);

		$post_service_register_response = "post_service_register_response";

		$result = $myBucket->insert($post_service_register_response, array(
				"docNme"=>$post_service_register_response,
				"bucket"=>"response",
				"docValues"=>[array(
					"code"=> 0,
		  			"message"=> "string",
		  			"token"=> "string"
				)]
			)
		);

		$post_service_send_values = "post_service_send_values";

		$result = $myBucket->insert($post_service_send_values, array(
				"docNme"=>$post_service_send_values,
				"bucket"=>"data",
				"docValues"=>[array(
					"token"=>"string",
					"services"=>[array(
						"service_id"=> 0,
		    			"params"=> [array(
		        			"name"=> "string",
		        			"type"=> "string"
		        		)]
					)]
				)]
			)
		);

		$get_service_list_response= "get_service_list_response";

		$result = $myBucket->insert($get_service_list_response, array(
				"docNme"=>$get_service_list_response,
				"bucket"=>"response",
				"docValues"=>[array(
					"code"=> 0,
		  			"values"=> [array(
		      				"id"=> 0,
		      				"header_code"=> 0,
		      				"message"=> "string"
		    		)]
		    	)]
	  		)
		);

		$get_service_list_required= "get_service_list_required";

		$result = $myBucket->insert($get_service_list_required, array(
				"docNme"=>$get_service_list_required,
				"bucket"=>"service",
				"docValues"=>[array(
					"token"=> "string"
				)]
  			)
		);

		$get_log_list_required= "get_log_list_required";

		$result = $myBucket->insert($get_log_list_required, array(
				"docNme"=>$get_log_list_required,
				"bucket"=>"data",
				"docValues"=>[array(
					"token"=> "string",
		  			"start_date"=>"string",
			  		"end_date"=>"string",
			  		"limit"=>"string",
			  		"order"=>"boolean"
			  	)]
		  	)
		);

		$get_log_list_response= "get_log_list_response";

		$result = $myBucket->insert($get_log_list_response, array(
				"docNme"=>$get_log_list_response,
				"bucket"=>"response",
				"docValues"=>[array(
					"code"=> 0,
		  			"values"=> [array(
		      				"id"=> 0,
		      				"header_code"=> 0,
		      				"message"=> "string"
		    		)]
		  		)]
  			)
		);
    		}
	}



	$metadosCodHttpCb = array(
						array("codHttp"=> "200",
						 "codCouch"=> "00",
						 "message"=> "Sucess"
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
$itensAdd=0;

$cluster='127.0.0.1:8091';


$couchbase->conchBaseInsertKey($cluster);

$couchbase->metadataInsertDocs($cluster);

for ($i = 0; $i < count($metadosCodHttpCb); $i++) //
{
	$couchbase->metadataInsert($metadosCodHttpCb[$i]["codHttp"],$metadosCodHttpCb[$i]["codCouch"], $metadosCodHttpCb[$i]["message"]); //get a message object
	$itensAdd++;
}

if ($itensAdd == 59) {
	echo "successfully added your Metadata Library!<b>";
}else{
	echo "There not were added all items. Contact your system administrator.<b>";
}


/*
 *Example metadata document for http or Couchbase Message
 *{
 * "codHttp": "200",
 * "codCouch": "00",
 * "message": "OK, Sucess"
 *}
*/
?>
