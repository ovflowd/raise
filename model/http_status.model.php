<?php

/**
 * Class HttpStatus
 */
class HTTPStatus
{
    var $code;
    var $message;


    /**
     * @param integer $code
     */
    public function __construct($code)
    {
        self::set_code($code);
        self::set_message();
    }

    private function set_message()
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

    public function get_code()
    {
        return $this->code;
    }

    public function set_code($code)
    {
        $this->code = $code;
    }

}