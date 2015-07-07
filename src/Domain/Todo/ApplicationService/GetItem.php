<?php

namespace Domain\Todo\ApplicationService;

use Aura\Payload\Payload;

class GetItem
{
	use UserAllowedDomain;
 
    /**
     *
     * @param  TodoId $todoId
     * 
     * @return Payload
     * 
     */
    public function todoWithId($todoId)
    {           
        $list = $this->mapper->fetchListFor($userId);
       
        if ($payload = $this->foundOrNotPayload($list, $userId)) {
            return $payload;
        }

        return $this->payload
                ->setStatus(Payload::FOUND)
                ->setMessages(['list was found'])
                ->setInput($userId)
                ->setOutput($list);
    }

}