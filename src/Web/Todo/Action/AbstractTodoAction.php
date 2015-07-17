<?php

namespace Todo\Action;

use Domain\Domain;
use Arbiter\Action;
use Aura\Web\Request;
use Radar\Adr\Input;

// prefilter (num) or (email) with (filterus?) lib? 
class AbstractTodoAction extends Action {
    public function __construct(
        Input $input,
        Domain $domain, 
        $responder
    ) {
        $this->input = $input;
        $this->domain = $domain;
        $this->responder = $responder;
    }
    
    // can have parameters as array() or could change for single parameters
    // abstract function __invoke(...) : Payload; 
}