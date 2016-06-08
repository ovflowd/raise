<?php

namespace UIoT\database;

use PDO;
use PDOException;
use UIoT\messages\DatabaseConnectionFailedMessage;
use UIoT\properties\DatabaseProperties;
use UIoT\util\MessageHandler;

/**
 * Class DatabaseConnector
 * @package UIoT\database
 */
final class DatabaseHandler
{
    /**
     * @var string Database user.
     */
    private $user;

    /**
     * @var string Database password.
     */
    private $pass;

    /**
     * @var string Database name.
     */
    private $name;

    /**
     * @var string Database host.
     */
    private $host;

    /**
     * @var string Database type.
     */
    private $type;

    /**
     * @var int Database port.
     */
    private $port;

    /**
     * DatabaseConnector constructor.
     */
    public function __construct()
    {
        $this->setUser(DatabaseProperties::getUser());
        $this->setPass(DatabaseProperties::getPassword());
        $this->setName(DatabaseProperties::getName());
        $this->setHost(DatabaseProperties::getHost());
        $this->setType(DatabaseProperties::getType());
        $this->setPort(DatabaseProperties::getPort());
    }

    /**
     * Returns a PDO Object based on the attributes.
     *
     * @return PDO
     */
    public function getInstance()
    {
        try {
            return new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->name}", $this->user, $this->pass);
        } catch (PDOException $e) {
            MessageHandler::getInstance()->endExecution(new DatabaseConnectionFailedMessage);
        }

        return null;
    }

    /**
     * Gets the name attribute. | @see $name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name attribute. | @see $name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Gets the host attribute. | @see $host
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Sets the host attribute. | @see $host
     *
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * Gets the port attribute. | @see $port
     *
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Sets the port attribute. | @see $port
     *
     * @param int $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }


    /**
     * Gets the type attribute. | @see $type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type attribute. | @see $type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Gets the user attribute. | @see $user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets the user attribute. | @see $user
     *
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Get the pass attribute. | @see $pass
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Sets the pass attribute. | @see $pass
     *
     * @param string $pass
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
    }
}
