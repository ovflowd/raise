<?php

namespace App\Managers;

/**
 * Class ResponseManager.
 */
class ResponseManager
{
    /**
     * Add a Header to the Response
     *
     * @param String $name
     * @param String $value
     * @return mixed
     */
    public abstract function addHeader(String $name, String $value);

    /**
     * Set the Response Content
     *
     * @param int $httpCode
     * @param $description
     * @return mixed
     */
    public abstract function setResponse(Integer $httpCode, $description);

    /**
     * Get the Response Content
     *
     * @return mixed
     */
    public abstract function getResponse();
}
