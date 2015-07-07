<?php

namespace Domain\Todo\ApplicationService;

use Aura\Payload\Payload;

class GetList
{
	use UserAllowedDomain;

    /**
     * 
     * @param  array $list 
     * 
     * @return Payload|null
     * 
     */
    public function didNotFindListPayload($list) 
    {
        if (count($list) === 0 || null === $list) {
            return $this->payload
                ->setStatus(Payload::NOT_FOUND)
                ->setMessages(['the list was not found for userId'])
                ->setOutput(['list' => null, 'something else' => 'times2']);
        }
        return null;
    }
    /**
     *
     * can filter by daterange, or other Criteria|Specifications depending 
     * 
     * @param  UserId $userId
     * 
     * @return Payload
     * 
     */
    public function listForUserId($userId)
    {           
        $list = $this->gateway->fetchListFor($userId);
       
        if ($payload = $this->didNotFindListPayload($list, $userId)) {
            // echo "it was not found";
            // var_dump($payload);
            return $payload;
        }

        return $this->payload
                ->setStatus(Payload::FOUND)
                ->setMessages(['list was found'])
                ->setInput($userId)
                ->setOutput($list);
    }
    /**
     * 
     * @param UserId $criteria  (or other things you want to use as Criteria)
     * 
     * @return Payload
     * 
    
    public function listMatching($criteria) 
    {         
        // can filter by daterange, or whatever depending 
        $list = $this->gateway->fetchListFor($criteria);

        if ($payload = $this->foundOrNotPayload($list)) {
            return $payload;
        }

        return $this->payload
            ->setStatus(Payload::FOUND)
            ->setOutput($todo)
            ->setInput([$criteria])
            ->setMessages('found the Todo matching what you were looking for');

    } */
}