<?php

/*

Example metadata document for http or Couchbase Message

{
  "codHttp": "200",
  "codCouch": "00",
  "message": "OK, Sucess"
}

*/

class Message {

	var $code_http;
	var $code_cb;
	var $message;

	public function __construct($code) {
		self::set_code($code);
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

}

