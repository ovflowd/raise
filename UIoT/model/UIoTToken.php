<?php

namespace UIoT\model;

use UIoT\database\DatabaseManager;

/**
 * Class UIoTToken
 * @package UIoT\model
 */
class UIoTToken
{
    /**
     * @var DatabaseManager
     */
    private $connection;

    /**
     * UIoTToken constructor.
     *
     * @param DatabaseManager $manager
     */
    public function __construct(DatabaseManager $manager)
    {
        $this->connection = $manager;
    }

    /**
     * Validate Token
     *
     * @param $token
     * @return bool
     */
    public function validateCode($token)
    {
        $currentTime = time();

        $getTokenStatement = $this->connection->fastExecute('SELECT * FROM DEVICE_TOKENS WHERE DVC_TOKEN = :token AND DVC_TOKEN_EXPIRE > :currentTime ORDER BY DVC_ID DESC LIMIT 1',
            [':token' => $token, ':currentTime' => $currentTime]);

        return $getTokenStatement->rowCount() > 0;
    }

    /**
     * Get Device from Token Id
     *
     * @param $token
     * @return mixed
     */
    public function getDeviceIdFromToken($token)
    {
        $getToken = $this->connection->fastExecute('SELECT (DVC_ID) FROM DEVICE_TOKENS WHERE DVC_TOKEN = :token',
            [':token' => $token]);

        return $getToken->fetch()['DVC_ID'];
    }

    /**
     * Update Token Expire-Date while it's still valid.
     *
     * @param $token
     */
    public function updateTokenExpire($token)
    {
        $this->connection->fastExecute('UPDATE DEVICE_TOKENS SET DVC_TOKEN_EXPIRE = :expire WHERE DVC_TOKEN = :token',
            [':token' => $token, ':expire' => $this->getExpireTime()]);
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

    /**
     * Define token
     *
     * @param $deviceId
     * @return mixed
     */
    public function defineToken($deviceId)
    {
        $generateToken = $this->generateRandomToken();

        $this->connection->fastExecute('INSERT INTO DEVICE_TOKENS VALUES (:device_id, :token, :expire) ON DUPLICATE KEY UPDATE DVC_TOKEN = :token, DVC_TOKEN_EXPIRE = :expire',
            [':device_id' => $deviceId, ':token' => $generateToken, ':expire' => $this->getExpireTime()]);

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
}
