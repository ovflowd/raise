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
use UIoT\Factories\InstructionFactory;
use UIoT\Models\MessageModel;
use UIoT\Models\ResourceModel;

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
    private $statementResponse;

    /**
     * MySQL Response Values
     *
     * @var object[]
     */
    private $responseValues;

    /**
     * RAISe Instruction Factory
     *
     * @var InstructionFactory
     */
    private $instructionFactory;

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
     *
     * Return the Message also
     *
     * @return null|MessageModel
     */
    public function execute()
    {
        $this->instructionFactory = RaiseManager::getInstance()->getFactory('instructionFactory');

        switch (RaiseManager::getInstance()->getHandler('requestHandler')->getRequest()->getMethod()) {
            case 'GET':
                $this->statementResponse = DatabaseManager::getInstance()->query(
                    $this->instructionFactory->getInstruction(), $this->instructionFactory->getStatement());
                $this->responseValues = $this->statementResponse->fetchAll(PDO::FETCH_OBJ);
                break;
            case 'POST':
                $this->statementResponse = DatabaseManager::getInstance()->query(
                    $this->instructionFactory->getInstruction(), $this->instructionFactory->getStatement());
                $this->lastInsertId = DatabaseManager::getInstance()->getHandler()->getConnection()->lastInsertId();
                break;
            default:
                $this->statementResponse = DatabaseManager::getInstance()->query(
                    $this->instructionFactory->getInstruction(), $this->instructionFactory->getStatement());
                break;
        }

        return $this->getMessage();
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
        return $this->responseValues;
    }

    /**
     * Get the correspondent RAISe Message if an error is throw'd
     * If not, return null that means that does'nt happened any error.
     *
     * @return null|MessageModel|MessageModel[]
     */
    public function getMessage()
    {
        if ($this->statementResponse->errorCode() == '0000' || empty($this->statementResponse->errorCode())) {
            return null;
        }

        switch ($this->statementResponse->errorCode()) {
            default:
                return RaiseManager::getInstance()->getFactory('messageFactory')->get('DefaultError', ['message' => $this->statementResponse->errorInfo()[2]]);
            case 'HY000':
                /** @var ResourceModel $resource */
                $resource = RaiseManager::getInstance()->getFactory('resourceFactory')->get(
                    RaiseManager::getInstance()->getHandler('requestHandler')->getResource());

                return RaiseManager::getInstance()->getFactory('messageFactory')->get('RequiredArgument', ['argument' => $resource->getProperties()->get(explode("'",
                    $this->statementResponse->errorInfo()[2])[1])->getFriendlyName()]);
            case '21S01':
                return RaiseManager::getInstance()->getFactory('messageFactory')->get('EmptyArguments');
        }
    }
}
