<?php

namespace Todo\Action;

use Domain\User\ApplicationService\UserService;
use Arbiter\Action;
use Aura\Web\Request;
use Radar\Adr\Input;

class AbstractTodoAction extends Action {
    protected $userDomain;
    protected $todoDomain;

    public function __construct(
        Input $input,
        $todoDomain,
        UserService $userDomain, 
        $responder
    ) {
        $this->input = $input;
        $this->todoDomain = $todoDomain;
        $this->userDomain = $userDomain;
        $this->responder = $responder;
    }
    
    // Action uses Input, whatever (had Request)
    // why isn't it $this->responder->setPayload($payload); && return $this->responder->__invoke();
    // $input['cookies']
    // should there be multiple Actions, or multiple Inputs, or is this fine?
    // prefilter (num) or (email) with filterus lib? 
    // then determine best place for validating
    // abstract public function __invoke($input) {
}