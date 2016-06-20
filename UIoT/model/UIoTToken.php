<?php

namespace UIoT\model;

use PDO;

/**
 * Class UIoTToken
 * @package UIoT\model
 */
class UIoTToken
{
    /**
     * @var PDO
     */

    private $connection;

    /**
     * UIoTToken constructor.
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param $deviceId
     */
    public function defineToken($deviceId)
    {
        $generateToken = $this->generateRandomToken();
        $this->getConnection()->query("INSERT INTO devices_tokens VALUES ('{$deviceId}', '{$generateToken}', '0') ON DUPLICATE KEY UPDATE DVC_TOKEN = '{$deviceId}' DVC_TOKEN_EXPIRE='123'");
    }

    /**
     * Generate Random Token String
     *
     * @return mixed
     */
    public function generateRandomToken()
    {
        return sha1(uniqid(rand(), true)); // TODO: Better token generation??
    }

    /**
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }
}