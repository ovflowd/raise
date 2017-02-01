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

class Message
{
  /**
  *@var string  $code_http  HTTP code of response message.
  */

  var $code_http;

  /**
  *@var string  $code_cb  Couchbase code of response message.
  */

  var $code_cb;

  /**
  *@var string  $message  response message.
  */
  var $message;

  /**
  *
  */

  public function __construct($codeHttp, $codeCb, $message)
  {
        self::set_code_http($codeHttp);
        self::set_code_cb($codeCb);
        self::set_message($message);
  }

  /**
  *@param string  $code Code of HTTP
  */

  public function set_code_http($code)
  {
    $this->code_http = $code;
  }

  /**
  *@return  string  Code HTTP
  */

  public function get_code_http()
  {
    return $this->code_http;
  }

  /**
  *@param string  $code Code of Couchbase exception
  */

  public function set_code_cb($code)
  {
    $this->code_cb = $code;
  }

  /**
  *@return  string  Couchbase code
  */

  public function get_code_cb()
  {
    return $this->code_cb;
  }

  /**
  *@param string  $message  Response Message
  */

  public function set_message($message)
  {
    $this->message = $message;
  }

  /**
  *@return  string  Response message
  */

  public function get_message()
  {
    return $this->message;
  }

  /**
  *Method for construct message object
  *
  *@return object with http code and response message.
  */

  public function message_out()
  {
    $messageOut = (object) array('code' => $this->get_code_http(), 'message' => $this->get_message());
    http_response_code($this->get_code_http());
    return $messageOut;
  }

}
