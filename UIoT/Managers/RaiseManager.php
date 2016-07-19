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

use Interfaces\FactoryInterface;
use UIoT\Factories\InstructionFactory;
use UIoT\Factories\MessageFactory;
use UIoT\Factories\ResourceFactory;
use UIoT\Handlers\RequestHandler;
use UIoT\Handlers\ResponseHandler;

/**
 * Class RaiseManager
 * @package UIoT\Managers
 */
class RaiseManager
{
    /**
     * @var RequestHandler
     */
    private $requestHandler;

    /**
     * @var ResponseHandler
     */
    private $responseHandler;

    /**
     * @var ResourceFactory
     */
    private $resourceFactory;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var InstructionFactory
     */
    private $instructionFactory;

    /**
     * Instantiate all RAISe Components
     */
    protected function __construct()
    {
        $this->getFactory('messageFactory', new MessageFactory);
        $this->getHandler('requestHandler', new RequestHandler);
        $this->getHandler('responseHandler', new ResponseHandler);
        $this->getFactory('resourceFactory', new ResourceFactory);
        $this->getFactory('instructionFactory', new InstructionFactory);
    }

    /**
     * Get a RAISe Factory or Handler
     *
     * @param string $raiseComponent RAISe Component Name
     * @param FactoryInterface|null $classToInstantiate Factory to Instantiate if Necessary
     * @return FactoryInterface
     */
    public function getFactory($raiseComponent, FactoryInterface $classToInstantiate = null)
    {
        if (null === $this->{$raiseComponent}) {
            $this->{$raiseComponent} = $classToInstantiate;
        }

        return $this->{$raiseComponent};
    }

    /**
     * Get a RAISe Factory or Handler
     *
     * @param string $raiseComponent RAISe Component Name
     * @param ResponseHandler|RequestHandler $classToInstantiate Class to Instantiate if Necessary
     * @return RequestHandler|ResponseHandler
     */
    public function getHandler($raiseComponent, $classToInstantiate = null)
    {
        if (null === $this->{$raiseComponent}) {
            if ($classToInstantiate instanceof RequestHandler || $classToInstantiate instanceof ResponseHandler) {
                $this->{$raiseComponent} = $classToInstantiate;
            }
        }

        return $this->{$raiseComponent};
    }

    /**
     * Execute's RAISe Management Engine
     *
     * @return string
     */
    public static function startRaise()
    {
        /* first instantiate RaiseManager and after this
            execute RAISe Interaction */
        self::getInstance()->executeInteraction();

        /* set HTTP Headers from HTTP Response Interface */
        self::getInstance()->getHandler('responseHandler')->getResponse()->sendHeaders();

        /* get HTTP Response Interface Content */
        return self::getInstance()->getHandler('responseHandler')->getResponse()->getContent();
    }

    /**
     * Execute's RAISe Interaction Procedures
     */
    public function executeInteraction()
    {
        /* check if Request is to DocumentRoot, if yes Welcome Message is triggered */
        if ($this->getHandler('requestHandler')->getRequest()->getRequestUri() == '/') {
            $this->getHandler('responseHandler')->setMessage($this->getFactory('messageFactory')->get('WelcomeToRaise'));

            return;
        }

        /* in other way executes the Interaction */
        $this->getHandler('responseHandler')->executeInteraction(InteractionManager::getInstance()->getByMethod(
            $this->getHandler('requestHandler')->getRequest()->getMethod()));
    }

    /**
     * Get RAISe Manager Instance
     *
     * @return RaiseManager
     */
    public static function getInstance()
    {
        static $instance = null;

        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }
}
