<?php

namespace UIoT\database;

use Exception;
use PDO;
use UIoT\exceptions\DatabaseConnectionFailedException;
use UIoT\properties\DatabaseProperties;

/**
 * Class DatabaseConnector
 *
 * @package UIoT\database
 * @property string $user
 * @property string $pass
 * @property string $name
 * @property string $host
 * @property string $type
 * @property int $port
 */
final class DatabaseConnector
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
        self::setUser(DatabaseProperties::DB_USER());
        self::setPass(DatabaseProperties::DB_PASS());
        self::setName(DatabaseProperties::DB_NAME());
        self::setHost(DatabaseProperties::DB_HOST());
        self::setType(DatabaseProperties::DB_TYPE());
        self::setPort(DatabaseProperties::DB_PORT());
    }

    /**
     * Returns a PDO Object based on the attributes.
     *
     * @return PDO
     * @throws DatabaseConnectionFailedException
     */
    public function getPdoObject()
    {
        $conn = null;
        
        try {
            $conn = self::getMySqlConnection();
        } catch (Exception $exception) {
            throw new DatabaseConnectionFailedException();
        }
        
        return $conn;
    }

    /**
     * Creates and returns a MySQL connection (PDO).
     *
     * @return PDO
     */
    private function getMySqlConnection()
    {
        $conn = new PDO("mysql:host={$this->host};
						port={$this->port};
						dbname={$this->name}",
            self::getUser(),
            self::getPass(),
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        return $conn;
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
        $this->name = (isset($name) ? $name : NULL);
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
        $this->host = (isset($host) ? $host : NULL);
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
        $this->port = (isset($port) ? $port : NULL);
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
        $this->type = (isset($type) ? $type : NULL);
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
        $this->user = (isset($user) ? $user : NULL);
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
        $this->pass = (isset($pass) ? $pass : NULL);
    }


}
