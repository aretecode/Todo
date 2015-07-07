<?php

namespace Web;

use Aura\View\View;
use Aura\Web\Response;
use Aura\Accept\Accept;
use Domain\Payload\PayloadInterface;
use Radar\Adr\Responder\Responder;

abstract class AbstractResponder extends Responder
{
    protected $accept;
    protected $available = array();
    protected $response;
    protected $payload;
    protected $payload_method = array();
    protected $view;


    // PayloadInterface
    public function setPayload( $payload)
    {
        echo "payload set";
        $this->payload = $payload;
    } 

    // example-code
    // what used to be in here is in Radar Responder
}