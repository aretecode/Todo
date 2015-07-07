<?php

namespace Domain\Todo\ApplicationService;

use Aura\Payload\Payload;
use Exception;

class DeleteItem
{
	use UserAllowedDomain;
    
    public function delete($todoId)
    {            
        $todo = $this->gateway->fetchOneById($todoId); 
        
        // or use the UserId also in the `fetchOneById` but this gives a nicer payload
        if ($payload = $this->todoNotFoundPayload($todo, $todoId, $todoId) /*?: 
            $payload = $this->hasSameUserIdPayload($todo, $userId)*/) {
            return $payload;
        }

        try {
            $this->gateway->delete($todo);
            return $this->payload
                ->setStatus(Payload::DELETED)
                ->setOutput(['id' => $todoId]);
        } catch (Exception $e) {
            return $this->exceptionPayload($e, $todoId, Payload::NOT_DELETED);
        }
    }    
}