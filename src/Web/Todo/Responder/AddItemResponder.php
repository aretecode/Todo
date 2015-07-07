<?php

namespace Todo\Responder;

use Aura\View\View;
use Aura\Web\Response;
use Aura\Accept\Accept;
use Domain\Payload\PayloadInterface;
use Radar\Adr\Responder\Responder;

class AddItemResponder extends AbstractTodoResponder
{
    protected $payload_method = array(
        'CREATED' => 'CREATED',
        'NOT_VALID' => 'NOT_VALID',
        'NOT_CREATED' => 'NOT_CREATED',
    );

    protected function display()
    {
        $this->renderView('add');
    }
}