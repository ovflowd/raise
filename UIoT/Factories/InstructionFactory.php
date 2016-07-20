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

namespace UIoT\Factories;

use Interfaces\FactoryInterface;
use NilPortugues\Sql\QueryBuilder\Builder\MySqlBuilder;
use NilPortugues\Sql\QueryBuilder\Manipulation\Insert;
use NilPortugues\Sql\QueryBuilder\Manipulation\Select;
use NilPortugues\Sql\QueryBuilder\Manipulation\Update;
use NilPortugues\Sql\QueryBuilder\Syntax\Where;
use Symfony\Component\HttpFoundation\ParameterBag;
use UIoT\Interfaces\PropertyInterface;
use UIoT\Interfaces\ResourceInterface;
use UIoT\Managers\RaiseManager;

/**
 * Class InstructionFactory
 * @package UIoT\Factories
 */
class InstructionFactory implements FactoryInterface
{
    /**
     * MySQL Instruction Builder Instance
     *
     * The RAISe uses MySQL Query Builder to
     * perform higher dynamic QUERY operations
     *
     * @var MySqlBuilder
     */
    private $instructionBuilder;

    /**
     * @var string
     */
    private $queryType;

    /**
     * @var ParameterBag
     */
    private $queryString;

    /**
     * @var ResourceInterface|ResourceInterface[]
     */
    private $resourceModel;

    /**
     * @var Select|Insert|Update
     */
    private $instruction;

    /**
     * Normally a RAISE Factory does'nt have any parameters
     * The Factory normally will do his business logic in a black box.
     * In other words, the Factory will request the necessary data to work
     * through the RAISE Managers
     */
    public function __construct()
    {
        $this->instructionBuilder = new MySqlBuilder;
    }

    /**
     * Get the SQL Instruction String
     * to be used in Prepared Statement
     *
     * @return string
     */
    public function getInstruction()
    {
        return $this->instructionBuilder->write($this->execute());
    }

    /**
     * Get SQL Instruction Prepared Statements
     * Arguments to be used in Prepared Statement
     *
     * @return array
     */
    public function getStatement()
    {
        $this->execute();

        return $this->instructionBuilder->getValues();
    }

    /**
     * Executes the Instruction if does'nt has been executed.
     * And Return it.
     *
     * @return Insert|Select|Update
     */
    private function execute()
    {
        if ($this->instruction === null) {
            $this->queryType = RaiseManager::getInstance()->getHandler('requestHandler')->getRequest()->getMethod();
            $this->queryString = RaiseManager::getInstance()->getHandler('requestHandler')->getRequest()->query;
            $this->resourceModel = RaiseManager::getInstance()->getFactory('resourceFactory')->get(
                RaiseManager::getInstance()->getHandler('requestHandler')->getResource());
            $this->instruction = $this->setCriteria();
        }

        return $this->instruction;
    }

    /**
     * Set SQL Instruction Statement Type
     *
     * @return Select|Insert|Update
     */
    private function setType()
    {
        switch ($this->queryType) {
            default:
                return $this->instructionBuilder->select()->setTable($this->resourceModel->getInternalName());
            case 'POST':
                return $this->instructionBuilder->insert()->setTable($this->resourceModel->getInternalName());
            case 'PUT':
            case 'DELETE':
                return $this->instructionBuilder->update()->setTable($this->resourceModel->getInternalName());
        }
    }

    /**
     * Get All Resource Properties for the SQL Instruction
     *
     * @return array
     */
    private function getProperties()
    {
        return array_map(function ($property) {
            /** @var $property PropertyInterface */
            return $property->getInternalName();
        }, $this->resourceModel->getProperties()->getAll());
    }

    /**
     * Get Values by the Query String with the option of
     * Remove some of them
     *
     * @param array $valuesToRemove
     * @return array Values to Get
     */
    private function getValues(array $valuesToRemove = array())
    {
        $newArray = array();

        foreach (array_diff_key($this->queryString->all(), $valuesToRemove) as $property => $value) {
            $item = $this->resourceModel->getProperties()->get($property);

            if (!is_object($item)) {
                RaiseManager::getInstance()->getHandler('responseHandler')->endExecution(RaiseManager::getInstance()->getFactory('messageFactory')->get('UnexistentArgument', [
                    'argument' => $property
                ]));
            }

            $newArray[$item->getInternalName()] = $value;
        }

        return $newArray;
    }

    /**
     * Set the Columns or the Values of the SQL Instruction
     *
     * @return Select|Insert|Update SQL Instruction
     */
    private function setColumns()
    {
        switch ($this->queryType) {
            default:
                return $this->setType()->setColumns($this->getProperties());
            case 'POST':
                $values = $this->getValues(['token' => '', 'id' => '']);

                if (empty(array_filter($values))) {
                    RaiseManager::getInstance()->getHandler('responseHandler')->endExecution(RaiseManager::getInstance()->getFactory('messageFactory')->get('EmptyArguments'));
                }

                return $this->setType()->setValues($values);
            case 'PUT':
                return $this->setType()->setValues($this->getValues(['token' => '', 'id' => '']));
            case 'DELETE':
                return $this->setType()->setValues(['DELETED' => 1]);
        }
    }

    /**
     * Applies a Criteria in the SQL Instruction
     *
     * @param Where $where Where Operator
     * @param array $criteria SQL Criteria
     * @return Where Final Operator
     */
    private function getCriteria(Where $where, array $criteria)
    {
        foreach ($criteria as $property => $value) {
            $where->equals($property, $value);
        }

        return $where;
    }

    /**
     * Set the Criteria of the SQL Instruction
     *
     * @return Select|Insert|Update SQL Instruction
     */
    private function setCriteria()
    {
        switch ($this->queryType) {
            default:
                return $this->getCriteria($this->setColumns()->where(), $this->getValues());
            case 'POST':
                return $this->setColumns();
            case 'PUT':
            case 'DELETE':
                return $this->getCriteria($this->setColumns()->where(), ['ID' => $this->queryString->get('id')]);
        }
    }

    /**
     * Add a RAISE Model in the Factory Data
     *
     * Necessary the parameter must be an object.
     * And normally the Factory will in the constructor
     * add the items.
     *
     * @note The objects need be a RAISE Model
     * @deprecated Method not used
     *
     * @param object $item
     * @return void
     */
    public function add($item)
    {
        // Unused Method
    }

    /**
     * Add a set of RAISE Models in the Factory Data
     *
     * Necessary the parameter must be an array of objects.
     * And normally the Factory will in the constructor
     * add the items.
     *
     * @note The objects need be a RAISE Model
     * @deprecated Method not used
     *
     * @param object[] $items
     * @return void
     */
    public function addSet(array $items)
    {
        // Unused Method
    }

    /**
     * This method returns an item by his identifier.
     * Normally the Factory will receive the string,
     * and route (do) the search in his Data with a specific
     * rule from the Factory.
     *
     * The templateEngine variable is useful when the Router need
     * optional parameters. In the case of MessageFactory, the templateEngine
     * parameter is used to populate variables into values passed by parameter.
     *
     * Necessary the return need be an object or array of objects.
     * @deprecated Method not used
     *
     * @param string $item
     * @param array $templateEngine
     * @return object|object[]
     */
    public function get($item, array $templateEngine = array())
    {
        // Unused Method
    }

    /**
     * This method returns all set of Data stored in the Factory
     * @deprecated Method not used
     *
     * @return object[]|object
     */
    public function getAll()
    {
        // Unused Method
    }
}
