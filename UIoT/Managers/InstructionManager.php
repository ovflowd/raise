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

namespace UIoT\Managers;

use PDO;
use PDOStatement;

/**
 * Class InstructionManager
 * @package UIoT\Managers
 */
final class InstructionManager
{
    /**
     * MySQL Statement Response
     *
     * @var PDOStatement
     */
    private $statement;

    /**
     * MySQL Response Values
     *
     * @var object[]
     */
    private $response;

    /**
     * Last Insert Identification
     *
     * @var int
     */
    private $lastInsertId;

    /**
     * Get Instruction Manager Instance
     *
     * @return InstructionManager
     */
    public static function getInstance()
    {
        static $instance = null;

        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    /**
     * Execute's MySQL Query with the Instruction Factory
     * Generated Statement
     */
    public function execute()
    {
        $this->statement = DatabaseManager::getInstance()->query(RaiseManager::getFactory('instruction')->getInstruction(),
            RaiseManager::getFactory('instruction')->getStatement());

        switch (RaiseManager::getHandler('request')->getRequest()->getMethod()) {
            case 'GET':
                $this->response = $this->statement->fetchAll(PDO::FETCH_OBJ);
                break;
            case 'POST':
                $this->lastInsertId = DatabaseManager::getInstance()->getHandler()->getConnection()->lastInsertId();
                break;
        }
    }

    /**
     * Get SQL Query Last Insert Id
     *
     * @return int
     */
    public function getInsertId()
    {
        return $this->lastInsertId;
    }

    /**
     * Return the Values from the MySQL Query
     * Only if is a SELECT Query
     *
     * @return object[]
     */
    public function getValues()
    {
        return $this->response;
    }
}
