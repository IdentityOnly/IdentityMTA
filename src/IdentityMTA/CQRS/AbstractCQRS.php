<?php
namespace IdentityMTA\CQRS;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\Filter;

use Zend\EventManager\EventManager;

/**
 * An abstract Command Query Responsibility Segregation, serializable for
 * persistence.
 *
 * @abstract
 */
abstract class AbstractCQRS
{
    protected $hydrator;
    
    protected $eventManager;
    
    protected $executionStartTime;
    
    protected $executionEndTime;
    
    public function __construct() {
        $this->getEventManager()->attach('start', array($this, 'startExecution'), 100);
        $this->getEventManager()->attach('end', array($this, 'endExecution'), -1);
        
        $this->setExecutionStartTime(new DateTime);
        $this->setExecutionEndTime(new DateTime);
    }
    
    abstract public function execute();
    
    public function getFQN() {
        return get_called_class();
    }
    
    /**
     * Serialize the parameters of this CQRS for persistence.
     *
     * @return array
     */
    public function serialize()
    {
        $hydrator = $this->getHydrator();
        $data = $hydrator->extract($this);
        
        return $data;
    }
    
    /**
     * Unserialize the given data into
     * parameters for this CQRS.
     *
     * @param array $data
     * @return void
     */
    public function unserialize($data)
    {
        $hydrator = $this->getHydrator();
        return $hydrator->hydrate($data, $this);
    }
    
    public function startExecution() {
        $this->setExecutionStartTime(new DateTime);
    }
    
    public function endExecution() {
        $this->setExecutionEndTime(new DateTime);
    }
    
    public function getHydrator() {
        if(!$this->hydrator) {
            $hydrator = new ClassMethods;
            $hydrator->setUnderscoreSeparatedKeys(false);
            $this->addHydratorMethodFilter($hydrator, 'getHydrator');
            $this->addHydratorMethodFilter($hydrator, 'getEventManager');
            $this->addHydratorMethodFilter($hydrator, 'getFQN');
            $this->addHydratorMethodFilter($hydrator, 'getExecutionStartTime');
            $this->addHydratorMethodFilter($hydrator, 'getExecutionEndTime');

            $this->hydrator = $hydrator;
        }
        return $this->hydrator;
    }
    
    public function setHydrator($hydrator) {
        $this->hydrator = $hydrator;
        return $this;
    }
    
    public function getEventManager() {
        if(!$this->eventManager) {
            $this->eventManager = new EventManager;
        }
        return $this->eventManager;
    }
    
    public function setEventManager($eventManager) {
        $this->eventManager = $eventManager;
        return $this;
    }
    
    public function getExecutionStartTime() {
        return $this->executionStartTime;
    }
    
    public function setExecutionStartTime($executionStartTime) {
        $this->executionStartTime = $executionStartTime;
        return $this;
    }
    
    public function getExecutionEndTime() {
        return $this->executionEndTime;
    }
    
    public function setExecutionEndTime($executionEndTime) {
        $this->executionEndTime = $executionEndTime;
        return $this;
    }
    
    protected function addHydratorMethodFilter($hydrator, $method) {
        $hydrator->addFilter($method, new Filter\MethodMatchFilter($method), Filter\FilterComposite::CONDITION_AND);
    }
}
