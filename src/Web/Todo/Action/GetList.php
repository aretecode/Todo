<?php

namespace Todo\Action;

use Aura\Payload\Payload;

use Domain\Domain;
use Todo\Input\UserItemInput;
use Todo\Input\DeleteItemInput;
use Radar\Adr\Input;

use Todo\Responder\GetListResponder;

class GetList extends AbstractTodoAction 
{
    public function __construct(
        Input $input,
        Domain $domain, 
        GetListResponder $responder
    ) {
        parent::__construct($input, $domain, $responder);
    }

    public function __invoke($userId)
    {
        return $this->domain->listForUserId($userId); 
    }
}