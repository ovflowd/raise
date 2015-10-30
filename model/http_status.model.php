<?php

/**
 * Class HttpStatus
 */
class HTTPStatus
{
    var $code;
    var $message;

    public function __construct($code, $message)
    {
        self::set_code($code);
        self::set_message($message);
    }

    public function get_message()
    {
        return $this->message;
    }

    public function set_message($message)
    {
        if(is_null($message))
            self::set_default_msg();
        else
            $this->message = $message;
    }

    public function get_code()
    {
        return $this->code;
    }

    public function set_code($code)
    {
        $this->code = $code;
    }

    private function set_default_msg()
    {
        switch (self::get_code()) {
            case 400:
                $this->message = "Bad request";
                break;

            case 404:
                $this->message = "Resource not found";
                break;

            case 405:
                $this->message = "Method not allowed";
                break;
            default:
                self::set_message("");
                break;
        }
    }

}