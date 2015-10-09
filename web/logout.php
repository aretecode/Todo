<?php

//
use josegonzalez\Dotenv\Loader as Dotenv;

require '../vendor/autoload.php';

if (session_status() !== PHP_SESSION_ACTIVE) 
    session_start();

/**
 * alternatively, Dotenv::load(dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env');
 */
Dotenv::load([
    'filepath' => dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env',
    'toEnv' => true,
]);

$auth_factory = new Aura\Auth\AuthFactory($_COOKIE);
$auth = $auth_factory->newInstance();
// 

$logout_service = $auth_factory->newLogoutService(null);

$logout_service->logout($auth);

if ($auth->isAnon()) 
    echo "You are now logged out.";
else 
    echo "Something went wrong; you are still logged in.";


echo $auth->getStatus();
