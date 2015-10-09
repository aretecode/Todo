<?php

namespace Domain\Todo\ApplicationService;

use Aura\Payload\Payload;
use Domain\Todo\TodoEntity;

/**
 * 
 * If dealing with Views, `Add` makes more sense.
 * If just doing the operations, the word `Creat` makes more sense
 * 
 */
class AddItem {
    use UserAllowedDomain;
  
    /**        
     * 
     * if it already exists
     * 
     * @param string $description
     * 
     * @return Payload| boolean
     * 
     */
    function todoWithSameDescriptionPayload($description) {
        if ($this->gateway->hasTodoWithDescription($description)) {
            return $this->payload
                ->setStatus(Payload::NOT_CREATED)
                ->setInput(['a Todo with the same Description was found', ['description' => $description]]);
        }

        return false;
    }
    /**
     * 
     * @param String $description
     * 
     * @param UserId $userId     
     *  
     */
    public function add($description, $userId) {

        $todo = $this->factory->newEntity(['description' => $description,  'userId' => $userId]);
       
        // validate the entity
        if (! $this->filter->forInsert($todo)) {
            $this->payload
                ->setStatus(Payload::NOT_VALID)
                ->setMessages(['messages' => $this->filter->getMessages()])
                ->setOutput($todo->getData()); // ['description' => $todo->description()] // $todo->getData()
        }

        if ($payload = $this->todoWithSameDescriptionPayload($description)) { 
            return $payload;
        }

        try {
            $this->gateway->create($todo); // or save
            return $this->payload
                ->setStatus(Payload::CREATED)
                ->setInput([$description, $userId])
                ->setOutput(['description' => $todo->description()]);
        } catch (Exception $e) {
            return $this->exceptionPayload($e, [$description, $userId]);
        }    
    }

}