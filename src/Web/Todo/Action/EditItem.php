<?php

namespace Todo\Action;

use Aura\Payload\Payload;

use Domain\Todo\ApplicationService\EditItem as EditItemService;
use Domain\User\ApplicationService\UserService;

use Todo\Input\UserItemInput;
use Todo\Input\EditItemInput;
use Radar\Adr\Input;

use Todo\Responder\EditItemResponder;

class EditItem extends AbstractTodoAction  
{
    public function __construct(
        Input $input,
        EditItemService $todoDomain,
        UserService $userDomain, 
        EditItemResponder $responder
    ) {
        parent::__construct($input, $todoDomain, $userDomain, $responder);
    }

    public function __invoke($input) 
    {
        if ($payload = $this->userDomain->isUserNotAuthenticatedPayload()) {
            return $payload;
        }

        $user = $this->userDomain->currentUser();
        $payload = $this->todoDomain->edit($input['todoId'], $user->userId(), $input['description']);
        return $payload;
    }
}