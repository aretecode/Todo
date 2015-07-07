<?php

namespace Todo\Action;

use Aura\Payload\Payload;

use Domain\Todo\ApplicationService\GetList as GetListService;
use Domain\User\ApplicationService\UserService;

use Todo\Input\UserItemInput;
use Todo\Input\GetListInput;
use Radar\Adr\Input;

use Todo\Responder\GetListResponder;

class GetList extends AbstractTodoAction 
{
    public function __construct(
        Input $input,
        GetListService $todoDomain,
        UserService $userDomain, 
        GetListResponder $responder
    ) {
        parent::__construct($input, $todoDomain, $userDomain, $responder);
    }

    public function __invoke($userId) 
    {
        if ($payload = $this->userDomain->isUserNotAuthenticatedPayload()) {
            return $payload;
        }

        // $user = $this->userDomain->currentUser();$userId = $user->userId()
        $payload = $this->todoDomain->listForUserId($userId); 

        // var_dump($payload);
        return $payload;
    }
}