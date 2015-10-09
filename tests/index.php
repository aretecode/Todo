<?php

use Radar\Adr\Boot as RadarBoot;
use Radar\Adr\Route;
use Radar\Adr\Responder\Responder;

use Relay\Middleware\ExceptionHandler;
use Relay\Middleware\ResponseSender;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;

use Domain\Todo\ApplicationService\EditItem;

use Todo\AddItemTest;
use Todo\EditItemTest;
use Todo\GetListTest;
use Todo\DeleteItemTest;

require_once 'bootstrap.php';

$upone = str_replace('/tests', "", __DIR__);
loadDotEnv($upone);
createDefaultDatabase();

startSession();
$redirectPayload = redirectOnEmptyCookie();
modifyServerSuperGlobalVariable(__DIR__);

$pdo = \defaultTodoPdo();
$pdo->exec('TRUNCATE TABLE auraauthentication');
$pdo->exec('TRUNCATE TABLE todo');

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
