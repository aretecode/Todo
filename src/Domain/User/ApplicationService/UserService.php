<?php

// @26/06/15-14:03
// @26/06/15-11:25
namespace Domain\User\ApplicationService;

use Aura\Payload\Payload;

use Domain\User\UserGateway;
use Domain\User\UserFactory;

class UserService {
   
    protected $gateway;
    protected $factory;
    protected $payload;

    public function __construct(
        UserGateway $gateway,
        UserFactory $factory,
        Payload $payload
    ) {
        $this->gateway = $gateway;
        $this->factory = $factory;
        $this->payload = $payload;
    }

    /**
     * @ param $cookies - doesn't work...
     * 
     * @return Payload|boolean (backwards for use)
     */
    function isUserNotAuthenticatedPayload() {
        $user = $this->gateway->userForCurrentSession();
        if (! $user || ! $user->isAuthenticated()) {
            return $this->payload
                ->setStatus(Payload::NOT_AUTHENTICATED)
                ->setOutput('NOT_AUTHENTICATED')
                ->setMessages('NOT AUTHENTICATED')
                ->setInput('NOT_AUTHENTICATED, go to login.php (this should probably be in messages and then handled differently in the Responder?)');
        }        
        return false;
    }

    /**
     * @TODO: DEFINITELY IS WRONG 
     * @return UserEntity
     */
    function currentUser() {
        return $this->gateway->userForCurrentSession();
    }
}