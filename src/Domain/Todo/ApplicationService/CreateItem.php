<?php

namespace Domain\Todo\ApplicationService;

use Aura\Payload\Payload;
use Domain\Todo\Todo;

class CreateItem extends AddItem {
    /**
     * @param String $description
     * @param UserId $userId
     * @return Payload
     */
    public function create($description, $userId) {
        return $this->add($description, $userId);
    }
}