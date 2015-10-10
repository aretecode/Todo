<?php

namespace Todo\Action;

use Aura\Payload\Payload;

use Domain\Domain;
use Todo\Input\UserItemInput;
use Todo\Input\DeleteItemInput;
use Radar\Adr\Input;

use Todo\Responder\EditItemResponder;

class EditItem extends AbstractTodoAction  
{
    public function __construct(
        Input $input,
        Domain $domain, 
        EditItemResponder $responder
    ) {
        parent::__construct($input, $domain, $responder);
    }

    // can have parameters as array() or could change for single parameters
    public function __invoke($input) 
    {
        var_dump($input);
        $user = $this->domain->currentUser();
        $payload = $this->domain->edit($input['todoId'], $user->userId(), $input['description']);
        return $payload;
    }
}