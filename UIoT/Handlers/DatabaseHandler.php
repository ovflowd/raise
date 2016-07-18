<?php

/**
 * UIoT Service Layer
 * @version alpha
 *                          88
 *                          ""              ,d
 *                                          88
 *              88       88 88  ,adPPYba, MM88MMM
 *              88       88 88 a8"     "8a  88
 *              88       88 88 8b       d8  88
 *              "8a,   ,a88 88 "8a,   ,a8"  88,
 *               `"YbbdP'Y8 88  `"YbbdP"'   "Y888
 *
 * @author Universal Internet of Things
 * @license MIT <https://opensource.org/licenses/MIT>
 * @copyright University of Brasília
 */

namespace UIoT\Handlers;

use PDO;
use PDOException;
use UIoT\Managers\SettingsManager;
use UIoT\Models\Settings\DatabaseSettingsModel;

/**
 * Class DatabaseHandler
 * @package UIoT\Handlers
 */
class DatabaseHandler
{
    /**
     * Database Connection Instance
     *
     * @var PDO
     */
    private $databaseInstance;

    /**
     * Database Settings Block
     *
     * @var DatabaseSettingsModel
     */
    private $databaseSettings;

    /**
     * Creates a Database Handler Instance.
     *
     * The Database Connections Details are obtained by Settings Manager
     */
    public function __construct()
    {
        $this->databaseSettings = SettingsManager::getInstance()->getItem('database');
        $this->databaseInstance = null;
    }

    /**
     * Connects to the MySQL Database
     */
    public function connect()
    {
        if ($this->databaseInstance === null) {
            try {
                $this->databaseInstance = new PDO(
                    "mysql:host={$this->databaseSettings->__get('hostName')};" .
                    "port={$this->databaseSettings->__get('hostPort')};" .
                    "dbname={$this->databaseSettings->__get('connDataBase')}",
                    $this->databaseSettings->__get('connUser'), $this->databaseSettings->__get('connPass')
                );
            } catch (PDOException $e) {
                die ("<h2>RAISe failed to connect to Database.</h2><b>Details:</b> {$e}");
            }
        }
    }

    /**
     * Get's the Connection Instance from MySQL
     *
     * @warning Instance can be Null
     *
     * @return PDO|null
     */
    public function getConnection()
    {
        return $this->databaseInstance;
    }

    /**
     * Closes MySQL Connection Instance
     */
    public function closeConnection()
    {
        $this->databaseInstance = null;
    }
}

