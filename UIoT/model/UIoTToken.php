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
        $getTokenStatement = $this->getConnection()->prepare("SELECT * FROM DEVICE_TOKENS WHERE DVC_TOKEN = ? ORDER BY DVC_ID DESC LIMIT 1");
        $getTokenStatement->bindParam(1, $token);
        $getTokenStatement->execute();

        if($getTokenStatement->rowCount() > 0) {
            $device_id = $getTokenStatement->fetch()['DVC_ID'];
            $getDeviceStatement = $this->getConnection()->prepare("SELECT * FROM DEVICES WHERE ID = ?");
            $getDeviceStatement->bindParam(1, $device_id);
            return true;
        }

        return false;
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
        $time = time() + 3600;
        $setDeviceTokenStatement = $this->getConnection()->prepare("INSERT INTO DEVICE_TOKENS VALUES (:device_id, :token, :expire) ON DUPLICATE KEY UPDATE DVC_TOKEN = :token, DVC_TOKEN_EXPIRE = :expire;");
        $setDeviceTokenStatement->bindParam(':device_id', $deviceId);
        $setDeviceTokenStatement->bindParam(':token', $generateToken);
        $setDeviceTokenStatement->bindParam(':expire', $time);
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