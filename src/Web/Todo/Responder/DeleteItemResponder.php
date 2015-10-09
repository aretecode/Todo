<?php

namespace Todo\Responder;

use Aura\View\View;
use Aura\Web\Response;
use Aura\Accept\Accept;
use Domain\Payload\PayloadInterface;
use Radar\Adr\Responder\Responder;

class DeleteItemResponder extends Responder
{           
    // from example-code
    protected $payloadMethod = array(
        'NOT_FOUND' => 'notFound',
        'NOT_DELETED' => 'deleted',
        'DELETED' => 'notDeleted',
    );
}
