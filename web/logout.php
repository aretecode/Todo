<?php

require '../vendor/autoload.php';

startSession();
loadDotEnv(__DIR__);

$authFactory = new Aura\Auth\AuthFactory($_COOKIE);
$auth = $authFactory->newInstance();
// 

$logoutService = $authFactory->newLogoutService(null);
$logoutService->logout($auth);

if ($auth->isAnon()) 
    echo "You are now logged out.";
else 
    echo "Something went wrong; you are still logged in.";

echo $auth->getStatus();
