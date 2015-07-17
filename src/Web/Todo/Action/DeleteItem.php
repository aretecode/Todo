<?php

namespace Todo\Action;

use Aura\Payload\Payload;

use Domain\Domain;
use Todo\Input\UserItemInput;
use Todo\Input\DeleteItemInput;
use Radar\Adr\Input;

use Todo\Responder\DeleteItemResponder;

class DeleteItem extends AbstractTodoAction 
{
    public function __construct(
        Input $input,
        Domain $domain, 
        DeleteItemResponder $responder
    ) {
        parent::__construct($input, $domain, $responder);
    }


    public function __invoke($input) {
        return $this->domain->delete($input['id']);
    }
}