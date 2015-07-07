<?php

namespace Todo\Action;

use Aura\Payload\Payload;

use Domain\Todo\ApplicationService\AddItem as AddItemService;
use Domain\User\ApplicationService\UserService;

use Todo\Input\UserItemInput;
use Todo\Input\AddItemInput;
use Radar\Adr\Input;

use Todo\Responder\AddItemResponder;

class AddItem extends AbstractTodoAction 
{
    public function __construct(
        Input $input,
        AddItemService $todoDomain,
        UserService $userDomain, 
        AddItemResponder $responder
    ) {
        parent::__construct($input, $todoDomain, $userDomain, $responder);
    }
    
    public function __invoke($input) 
    {        
        if ($payload = $this->userDomain->isUserNotAuthenticatedPayload()) {
            return $payload;
        }
        $user = $this->userDomain->currentUser();
        $payload = $this->todoDomain->add($input, $user->userId()); // $input['description']
        return $payload;
    }
}