<?php
 
/**
 * Class RequestTestCase
 * Basic model class
 */

class RequestTestCase
{
    private $uri; /* String */
    private $body; /* Json */
    private $expected; /* Json */

    public function __construct($uri, $body, $expected)
    {
        $this->setRequest($uri);
        $this->setBody($body);
        $this->setExpected($expected);
        
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param mixed $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getExpected()
    {
        return $this->expected;
    }

    /**
     * @param mixed $expected
     */
    public function setExpected($expected)
    {
        $this->expected = $expected;
    }
    

    
}