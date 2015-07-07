<?php

namespace Domain\User;

use Aura\Sql\ExtendedPdo;

class UserGateway
{
    protected $pdo;
    protected $factory;
    
    public function __construct(ExtendedPdo $pdo, UserFactory $factory)
    {
        $this->pdo = $pdo;
        $this->factory = $factory;
    }

    // check to see if there is even one, right now it just auto signs in
    // aka: ::userForCurrentSession && ::user && ::userForCookies
    // could AutoInject? or where is the best place to access this cookie?
    // $_COOKIE COULD BE -> ADR REQUEST??
    // pass in cookie and set it in $INPUT?
    // https://github.com/harikt/authentication-pdo-example
    // this is not how to do it, but for now it is here... where SHOULD it go? in web/index?
    function userForCurrentSession($cookie = array()) {    
            
        ///
        $auth_factory = new \Aura\Auth\AuthFactory($_COOKIE); 
        $auth = $auth_factory->newInstance();

        $cols = array(
            'username', // "AS username" is added by the adapter
            'password', // "AS password" is added by the adapter
            'email',
            'fullname',
            'website'
        );
        $from = 'users';
        $where = 'active = 1';
        $hash = new \Aura\Auth\Verifier\PasswordVerifier(PASSWORD_DEFAULT);
        $pdo_adapter = $auth_factory->newPdoAdapter($this->pdo, $hash, $cols, $from, $where);
      
        ///
        $login_service = $auth_factory->newLoginService($pdo_adapter);
        $login_service->login($auth, array(
            'username' => 'harikt',
            'password' => 123456,
            )
        );  

        ///
        $session_username = $auth->getUserName();

        ///
        /*
        $stm = "SELECT id FROM `users` WHERE `active` = 1 AND `username` = '" .$session_username ."'";
        $sth = $this->pdo->prepare($stm);
        $sth->execute();
        $result = $sth->fetch(\PDO::FETCH_ASSOC);        
        */
        $stm = "SELECT id FROM `users` WHERE `active` = 1 AND `username` = :username";
        $bind = array('username' => $session_username);

        $result = $this->pdo->fetchOne($stm, $bind); //, 'Domain\User\UserEntity' , array('ctor_arg_1')




        ///
        $userData = array();
        $userData['userId'] = $result['id']; 
        $userData['authenticated'] = $auth->isValid(); // $auth->getStatus();
        $userData['username'] = $auth->getUserData();
        array_merge($userData, $auth->getUserData());

        $user = $this->factory->newEntity($userData);
        return $user;
    }



}
