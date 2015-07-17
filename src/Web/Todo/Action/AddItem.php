<?php

namespace Todo\Action;

use Aura\Payload\Payload;

use Domain\Domain;
use Radar\Adr\Input;

use Todo\Responder\AddItemResponder;

class AddItem extends AbstractTodoAction 
{
    public function __construct(
        Input $input,
        Domain $domain, 
        AddItemResponder $responder
    ) {
        parent::__construct($input, $domain, $responder);
    }
    
    public function __invoke($input) 
    {        
        $user = $this->domain->currentUser();
        return $payload = $this->domain->add($input, $user->userId()); // $input['description']
    }
}