<?php

use Radar\Adr\Boot as RadarBoot;
use Radar\Adr\Route;
use Radar\Adr\Responder\Responder;

use Relay\Middleware\ExceptionHandler;
use Relay\Middleware\ResponseSender;
use Zend\Diactoros\Response as Response;
use Zend\Diactoros\ServerRequestFactory;

use Domain\Todo\ApplicationService\EditItem;

use Todo\AddItemTest;
use Todo\EditItemTest;
use Todo\GetListTest;
use Todo\DeleteItemTest;

require_once 'bootstrap.php';

loadDotEnv(__DIR__.'/../');
createDefaultDatabase();

startSession();
$redirectPayload = redirectOnEmptyCookie();
modifyServerSuperGlobalVariable(__DIR__);

function login() {
    $auth_factory = new \Aura\Auth\AuthFactory($_COOKIE);
    $auth = $auth_factory->newInstance();
    //

    //
    $pdo = new \PDO($_ENV['DB_DSN'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
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

    $pdo_adapter = $auth_factory->newPdoAdapter($pdo, $hash, $cols, $from, $where);
    // 

    $login_service = $auth_factory->newLoginService($pdo_adapter);

    $login_service->login($auth, array(
        'username' => 'harikt',
        'password' => '123456',
        )
    );    
    $auth->setUserName('harikt');
}

login();


$addTest = new AddItemTest();
$addTest->setUp();
$addTest->testAddingSuccess();
$addTest->testAddingFailure();

$editTest = new EditItemTest();
$editTest->setUp();
$editTest->testUpdatingSuccess();
$editTest->testUpdatingFailure();

$getListTest = new GetListTest();
$getListTest->setUp();
$getListTest->testGetListFailure();
$getListTest->testGetListSuccess();

$deleteTest = new DeleteItemTest();
$deleteTest->setUp();
$deleteTest->testDeleteSuccess();
$deleteTest->testDeleteFailure();

// echo $one . $two . $three . $four;
// echo $one . $three . $four;

// $getItemTest, $userTest