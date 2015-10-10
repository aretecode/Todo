<?php

error_reporting(E_ALL);
$autoloader = __DIR__.'/../vendor/autoload.php';
if (! file_exists($autoloader)) {
    echo "Composer autoloader not found: $autoloader" . PHP_EOL;
    echo "Please issue 'composer install' and try again." . PHP_EOL;
    exit(1);
}
require $autoloader;

createDefaultDatabase();
startSession();
$redirectPayload = redirectOnEmptyCookie();
modifyServerSuperGlobalVariable(__DIR__);

function login() {
    $authFactory = new \Aura\Auth\AuthFactory($_COOKIE);
    $auth = $authFactory->newInstance();
    //

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

    $pdo = defaultTodoPdo();
    $pdoAdapter = $authFactory->newPdoAdapter($pdo, $hash, $cols, $from, $where);
    //

    $loginService = $authFactory->newLoginService($pdoAdapter);

    $loginService->login($auth, array(
        'username' => 'harikt',
        'password' => '123456',
        )
    );
    $auth->setUserName('harikt');
}

login();
