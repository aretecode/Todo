<?php

namespace Todo\Responder;

class EditItemResponder extends AbstractTodoResponder
{   
    // from example-code
    protected $payload_method = array(
        'Domain\Payload\Found' => 'found',
        'Domain\Payload\NotFound' => 'notFound',
    );
}