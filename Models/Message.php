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
*/

class Message {

	var $code_http;
	var $code_cb;
	var $message;

	public function __construct($codeHttp, $codeCb, $message) {
		self::set_code_http($codeHttp);
		self::set_code_cb($codeCb);
		self::set_message($message);
	}

	public function set_code_http($code) {
		$this->code_http = $code;
	}

	public function get_code_http() {
		return $this->code_http;
	}

	public function set_code_cb($code) {
		$this->code_cb = $code;
	}

	public function get_code_cb() {
		return $this->code_cb;
	}

	public function set_message($message) {
		$this->message = $message;
	}

	public function get_message() {
		return $this->message;
	}

	public function message_out() {
		$messageOut = (object) array('codeHttp' => $this->get_code_http(), 'message' => $this->get_message());
		return $messageOut;
	}


}

/*
 *Example metadata document for http or Couchbase Message
 *{
 * "codHttp": "200",
 * "codCouch": "00",
 * "message": "OK, Sucess"
 *}

 *{
 * "codHttp": "201",
 * "codCouch": "",
 * "message": "Created"
 *}

 *{
 * "codHttp": "202",
 * "codCouch": "",
 * "message": "Accepted"
 *}

 *{
 * "codHttp": "203",
 * "codCouch": "",
 * "message": "Non-Authoritative Information"
 *}

 *{
 * "codHttp": "204",
 * "codCouch": "",
 * "message": "No Content"
 *}

 *{
 * "codHttp": "205",
 * "codCouch": "",
 * "message": "Reset Content"
 *}

 *{
 * "codHttp": "206",
 * "codCouch": "",
 * "message": "Partial Content"
 *}

 *{
 * "codHttp": "207",
 * "codCouch": "",
 * "message": "Multi-Status"
 *}

 *{
 * "codHttp": "208",
 * "codCouch": "00",
 * "message": "Already Reported"
 *}

 *{
 * "codHttp": "226",
 * "codCouch": "",
 * "message": "IM Used"
 *}

 *{
 * "codHttp": "300",
 * "codCouch": "",
 * "message": "Multiple Choices"
 *}

 *{
 * "codHttp": "301",
 * "codCouch": "",
 * "message": "Moced Permanently"
 *}

 *{
 * "codHttp": "302",
 * "codCouch": "",
 * "message": "Found"
 *}

 *{
 * "codHttp": "303",
 * "codCouch": "",
 * "message": "See Other"
 *}

 *{
 * "codHttp": "304",
 * "codCouch": "",
 * "message": "Not Modified"
 *}

 *{
 * "codHttp": "305",
 * "codCouch": "",
 * "message": "Use Proxy"
 *}

 *{
 * "codHttp": "306",
 * "codCouch": "",
 * "message": "Swich Proxy"
 *}

 *{
 * "codHttp": "307",
 * "codCouch": "",
 * "message": "Temporary Redirect"
 *}

 *{
 * "codHttp": "308",
 * "codCouch": "",
 * "message": "Permanent Redirect"
 *}

 *{
 * "codHttp": "400",
 * "codCouch": "",
 * "message": "Bad Request"
 *}

 *{
 * "codHttp": "401",
 * "codCouch": "",
 * "message": "Unauthorized"
 *}

 *{
 * "codHttp": "402",
 * "codCouch": "",
 * "message": "Payment Required"
 *}

 *{
 * "codHttp": "403",
 * "codCouch": "",
 * "message": "Forbidden"
 *}

 *{
 * "codHttp": "404",
 * "codCouch": "",
 * "message": "Not Found"
 *}

 *{
 * "codHttp": "405",
 * "codCouch": "",
 * "message": "Method Not Allowed"
 *}

 *{
 * "codHttp": "406",
 * "codCouch": "",
 * "message": "Not acceptable"
 *}

 *{
 * "codHttp": "407",
 * "codCouch": "",
 * "message": "Proxy Authentication Required"
 *}

 *{
 * "codHttp": "408",
 * "codCouch": "",
 * "message": "Request Timeout"
 *}

 *{
 * "codHttp": "409",
 * "codCouch": "",
 * "message": "Conflict"
 *}

 *{
 * "codHttp": "410",
 * "codCouch": "",
 * "message": "Gone"
 *}

 *{
 * "codHttp": "411",
 * "codCouch": "",
 * "message": "Length Requered"
 *}

 *{
 * "codHttp": "412",
 * "codCouch": "",
 * "message": "Precondition Failed"
 *}

 *{
 * "codHttp": "413",
 * "codCouch": "",
 * "message": "Payload too Large"
 *}

 *{
 * "codHttp": "414",
 * "codCouch": "",
 * "message": "URI too Long"
 *}

 *{
 * "codHttp": "415",
 * "codCouch": "",
 * "message": "Unsupported Media Type"
 *}

 *{
 * "codHttp": "416",
 * "codCouch": "",
 * "message": "Range Not satisfiable"
 *}

 *{
 * "codHttp": "417",
 * "codCouch": "01",
 * "message": "Expectation Failed"
 *}

 *{
 * "codHttp": "418",
 * "codCouch": "",
 * "message": "I'm a teapot"
 *}

 *{
 * "codHttp": "421",
 * "codCouch": "",
 * "message": "Misdirected Request"
 *}

 *{
 * "codHttp": "422",
 * "codCouch": "",
 * "message": "Unprocessable Entity"
 *}

 *{
 * "codHttp": "423",
 * "codCouch": "",
 * "message": "Locked"
 *}

 *{
 * "codHttp": "424",
 * "codCouch": "",
 * "message": "Failed Dependency"
 *}

 *{
 * "codHttp": "426",
 * "codCouch": "",
 * "message": "Upgrade Required"
 *}

 *{
 * "codHttp": "428",
 * "codCouch": "",
 * "message": "Precodition Required"
 *}

 *{
 * "codHttp": "429",
 * "codCouch": "05",
 * "message": "Too Many Requests"
 *}

 *{
 * "codHttp": "431",
 * "codCouch": "",
 * "message": "Request Header Fields Too Large"
 *}

 *{
 * "codHttp": "451",
 * "codCouch": "",
 * "message": "Unavailable For Legal Reasons"
 *}

 *{
 * "codHttp": "500",
 * "codCouch": "06",
 * "message": "Internal Server Error"
 *}

 *{
 * "codHttp": "501",
 * "codCouch": "",
 * "message": "Not Implemented"
 *}

 *{
 * "codHttp": "502",
 * "codCouch": "",
 * "message": "Bad Gateway"
 *}

 *{
 * "codHttp": "503",
 * "codCouch": "08",
 * "message": "Service Unavailable"
 *}

 *{
 * "codHttp": "504",
 * "codCouch": "",
 * "message": "Gateway Timeout"
 *}

 *{
 * "codHttp": "505",
 * "codCouch": "",
 * "message": "HTTP version Not supported"
 *}

 *{
 * "codHttp": "506",
 * "codCouch": "",
 * "message": "Variant Also Negotiates"
 *}

 *{
 * "codHttp": "507",
 * "codCouch": "04",
 * "message": "Insufficient Storage"
 *}

 *{
 * "codHttp": "508",
 * "codCouch": "",
 * "message": "loop Detected"
 *}

 *{
 * "codHttp": "510",
 * "codCouch": "",
 * "message": "Not Extended"
 *}

 *{
 * "codHttp": "511",
 * "codCouch": "",
 * "message": "Network Authentication Required"
 */