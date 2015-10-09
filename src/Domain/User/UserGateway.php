<?php

namespace Domain\User;

use Aura\Sql\ExtendedPdo;
use Aura\Auth\AuthFactory;
use Aura\Auth\Verifier\PasswordVerifier;

class UserGateway
{
    protected $pdo;
    protected $factory;
    protected $authenticationFactory;

    public function __construct(ExtendedPdo $pdo, AuthFactory $authorizationFactory, UserFactory $factory)
    {
        $this->pdo = $pdo;
        $this->authenticationFactory = $authorizationFactory;
        $this->factory = $factory;
    }

    function userForCurrentSession() {    
        $auth = $this->authenticationFactory->newInstance();
        $sessionUsername = $auth->getUserName();

        /*
            using normal PDO insteadof ExtendedPdo
            $stm = "SELECT id FROM `users` WHERE `active` = 1 AND `username` = '" .$session_username ."'";
            $sth = $this->pdo->prepare($stm);
            $sth->execute();
            $result = $sth->fetch(\PDO::FETCH_ASSOC);        
        */
        $stm = "SELECT id FROM `users` WHERE `active` = 1 AND `username` = :username";
        $bind = array('username' => $sessionUsername);

        $result = $this->pdo->fetchOne($stm, $bind); //, 'Domain\User\UserEntity' , array('ctor_arg_1')

        $userData = array();
        $userData['userId'] = $result['id']; 
        $userData['authenticated'] = $auth->isValid(); // $auth->getStatus();
        $userData['username'] = $auth->getUserData();
        array_merge($userData, $auth->getUserData());

        $user = $this->factory->newEntity($userData);
        return $user;
    }



}
