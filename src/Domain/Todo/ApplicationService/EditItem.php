<?php

namespace Domain\Todo\ApplicationService;

use Aura\Payload\Payload;
use Exception;

class EditItem
{
    use UserAllowedDomain;

    /**
     * 
     * @TODO: could also edit by the old description
     * 
     * @param  String|TodoId $todoId
     * 
     * @param  String|UserId $userId
     * 
     * @param  String        $newDescription
     * 
     * @return Payload
     * 
     */
    public function edit($todoId, $userId, $newDescription)
    {         
        $todo = $this->gateway->fetchOneById($todoId); 
        
        if ($payload = $this->todoNotFoundPayload($todo, $todoId) ?: 
            $payload = $this->hasSameUserIdPayload($todo, $userId)) {
            return $payload;
        }
        
        try {
            // ensure that it is not the same as the old description
            $todo->changeDescription($newDescription);
            if ($payload = $this->validTodoPayload($todo)) {
                return $payload;
            }

            $this->gateway->update($todo);

            return $this->payload
                ->setStatus(Payload::UPDATED)
                ->setOutput(["description" => $todo->description()])
                ->setInput([$userId, $todoId])
                ->setMessages('updated the Todo');
        } catch (Exception $e) {
            return $this->exceptionPayload($e, $input, Payload::NOT_UPDATED);
        }
    }
}