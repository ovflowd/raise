<?php

namespace UIoT\model;

use UIoT\managers\RequestManager;

/**
 * Class UIoTToken
 * @package UIoT\model
 */
class UIoTToken
{
    /**
     * Validate Token
     *
     * @param $token
     * @return bool
     */
    public function validateCode($token)
    {
        if (RequestManager::getDatabaseManager()->rowCountExecute(
                'SELECT * FROM DEVICE_TOKENS WHERE DVC_TOKEN = :token AND DVC_TOKEN_EXPIRE > :currentTime ORDER BY DVC_ID DESC LIMIT 1',
                [':token' => $token, ':currentTime' => time()]) > 0
        ) {
            RequestManager::getTokenManager()->updateTokenExpire($token);

            return true;
        }

        return false;
    }

    /**
     * Update Token Expire-Date while it's still valid.
     *
     * @param $token
     */
    public function updateTokenExpire($token)
    {
        RequestManager::getDatabaseManager()->fastExecute('UPDATE DEVICE_TOKENS SET DVC_TOKEN_EXPIRE = :expire WHERE DVC_TOKEN = :token',
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
     * Get Device from Token Id
     *
     * @param $token
     * @return mixed
     */
    public function getDeviceIdFromToken($token)
    {
        $getToken = RequestManager::getDatabaseManager()->fetchExecute('SELECT (DVC_ID) FROM DEVICE_TOKENS WHERE DVC_TOKEN = :token',
            [':token' => $token])[0];

        return $getToken->DVC_ID;
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

        RequestManager::getDatabaseManager()->fastExecute(
            'INSERT INTO DEVICE_TOKENS VALUES (:device_id, :token, :expire) ON DUPLICATE KEY UPDATE DVC_TOKEN = :token, DVC_TOKEN_EXPIRE = :expire',
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
