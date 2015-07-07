<?php

namespace Todo\Action;

use Aura\Payload\Payload;

use Domain\User\ApplicationService\UserService;
use Domain\Todo\ApplicationService\DeleteItem as DeleteItemService;

use Todo\Input\UserItemInput;
use Todo\Input\DeleteItemInput;
use Radar\Adr\Input;

use Todo\Responder\DeleteItemResponder;

class DeleteItem extends AbstractTodoAction 
{

    public function __construct(
        Input $input,
        DeleteItemService $todoDomain,
        UserService $userDomain, 
        DeleteItemResponder $responder
    ) {        
        parent::__construct($input, $todoDomain, $userDomain, $responder);
    }

    public function __invoke($input) {
        if ($payload = $this->userDomain->isUserNotAuthenticatedPayload()) {
            return $payload;
        }

        $payload = $this->todoDomain->delete($input['id']);
        return $payload;
    }
}