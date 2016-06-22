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
     * Validade Token
     *
     * @param $token
     * @return bool
     */
    public function validateCode($token)
    {
        $currentTime = time();
        $getTokenStatement = $this->getConnection()->prepare("SELECT * FROM DEVICE_TOKENS WHERE DVC_TOKEN = :token AND DVC_TOKEN_EXPIRE > :currentTime ORDER BY DVC_ID DESC LIMIT 1");
        $getTokenStatement->bindParam(':token', $token);
        $getTokenStatement->bindParam(':currentTime', $currentTime);

        $getTokenStatement->execute();

        return $getTokenStatement->rowCount() > 0;
    }

    /**
     * Update Token Expire-Date while it's still valid.
     *
     * @param $token
     */
    public function updateTokenExpire($token)
    {
        $expire = $this->getExpireTime();
        $setDeviceTokenStatement = $this->getConnection()->prepare("UPDATE DEVICE_TOKENS SET DVC_TOKEN_EXPIRE = :expire WHERE DVC_TOKEN = :token;");
        $setDeviceTokenStatement->bindParam(':token', $token);
        $setDeviceTokenStatement->bindParam(':expire', $expire);
        $setDeviceTokenStatement->execute();
    }
    /**
     * Define token
     *
     * @param $deviceId
     * @return mixed
     */
    public function defineToken($deviceId)
    {
        $expire = $this->getExpireTime();
        $generateToken = $this->generateRandomToken();
        $setDeviceTokenStatement = $this->getConnection()->prepare("INSERT INTO DEVICE_TOKENS VALUES (:device_id, :token, :expire) ON DUPLICATE KEY UPDATE DVC_TOKEN = :token, DVC_TOKEN_EXPIRE = :expire;");
        $setDeviceTokenStatement->bindParam(':device_id', $deviceId);
        $setDeviceTokenStatement->bindParam(':token', $generateToken);
        $setDeviceTokenStatement->bindParam(':expire', $expire);
        $setDeviceTokenStatement->execute();
        return $generateToken;
    }

    /**
     * Generate Random Token String
     *
     * @return mixed
     */
    public function generateRandomToken()
    {
        return sha1(uniqid(rand(), true)); // TODO: needs a better token generation.
    }

    /**
     * Get connection from PDO
     *
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Get token's expiration limit (idle time)
     *
     * @return mixed
     */
    public function getExpireTime()
    {
        return time() + 3600;
    }
}