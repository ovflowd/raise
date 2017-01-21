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
        $messageOut = (object) array('code' => $this->get_code_http(), 'message' => $this->get_message());
        return $messageOut;
    }


}
