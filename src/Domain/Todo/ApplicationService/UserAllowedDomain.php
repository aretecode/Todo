<?php

namespace Domain\Todo\ApplicationService;

use Exception;
use Domain\Todo\TodoEntity; 
use Domain\User\User; // Likely User would be in a different Domain
use Domain\Todo\Mapper;
use Domain\Todo\TodoFilter;
use Domain\Todo\TodoGateway;
use Domain\Todo\TodoFactory;

use Aura\Payload\Payload;

trait UserAllowedDomain {
   
    protected $filter;
    protected $gateway;
    protected $factory;
    protected $payload;    

    public function __construct(
        TodoFilter $filter,
        TodoGateway $gateway,
        TodoFactory $factory,
        Payload $payload
    ) {
        $this->filter = $filter;
        $this->gateway = $gateway;
        $this->factory = $factory;
        $this->payload = $payload;
    }
    /**      
     *   
     * UserId could be obj with an ->equals?
     *
     * @return Payload| boolean
     * 
     */
    function hasSameUserIdPayload(TodoEntity $todo, $userId) {
        // or an equals function if the Id can be an object
        if ((string) $userId !== (string) $todo->userId()) {
            return $this->payload
                ->setStatus(Payload::NOT_AUTHORIZED)
                ->setInput($userId)
                ->setOutput($todo)
                ->setMessages('the UserId & the UserId on the Todo are not the same');
        }
        return false;
    }
    /**
     * 
     * was `idInInput`
     * 
     * @param string $key
     * 
     * @return Payload|boolean
     * 
     */
    function keyInInputPayload($key, array $input){
        if (! isset($input[$key])) {
            return $this->payload
                ->setStatus(Payload::NOT_VALID)
                ->setInput($input)
                ->setMessages([
                    $key => 'TodoEntity '.$key.' not set.'
                ]);
        }    
        return false;
    }
    /**
     * 
     * really a silly non intention-revealing interface name...
     *      
     * @param TodoEntity|null $todo
     *
     * @param array $input
     * 
     * @return Payload|boolean
     * 
     */
    function validTodoPayload($todo, $input = 'invalid') {
        if (! $this->filter->forUpdate($todo)) {
            return $this->payload
                ->setStatus(Payload::NOT_VALID)
                ->setMessages(['todo not found |& not valid'])
                ->setOutput($input)
                ->setInput($input);
        }
        return false;
    }
    function todoNotFoundPayload($todo, $todoId, $input = 'invalid') {
        if (! $todo) {
            return $this->payload
                ->setStatus(Payload::NOT_FOUND)
                ->setMessages(['todo not found (remember, not the description)'])
                ->setOutput('{"status":"NOT_FOUND", "todoId":"'. $todoId.'"}')
                ->setInput('{"status":"NOT_FOUND", "todoId":"'. $todoId.'"}');
        }
        return false;
    }
    /**
     * 
     * @param object $found 
     * 
     * @param array|mixed $input 
     * 
     * @return Payload|boolean
     *
     * @TODO: abstract this & merge with 2 above?
     * 
     */
    function foundOrNotPayload($found, $userId) { 
        if (! $found) {
            return $this->payload
                ->setStatus(Payload::NOT_FOUND)
                ->setMessages('todo was not found')
                ->setOutput('{"status":"NOT_FOUND", "userId":"'. $userId.'"}')
                ->setInput('{"status":"NOT_FOUND", "userId":"'. $userId.'"}');
        }            
        return false;
    }    
    /**
     * 
     * or error
     * could be a different trait
     * 
     * @return Payload
     * 
     */
    function exceptionPayload(Exception $exception, $input = array(), $status = Payload::ERROR) { 
        return $this->payload
            ->setStatus($status)
            ->setInput($input)
            ->setOutput($exception);
    }

}
