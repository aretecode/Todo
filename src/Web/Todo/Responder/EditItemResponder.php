<?php

namespace Todo\Responder;

class EditItemResponder extends AbstractTodoResponder
{   
    // from example-code
    protected $payloadMethod = array(
        'Domain\Payload\Found' => 'found',
        'Domain\Payload\NotFound' => 'notFound',
    );
}