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

require_once __DIR__.'/../vendor/autoload.php';

$upone = str_replace('/tests', "", __DIR__);
loadDotEnv($upone);
$redirectPayload = redirectOnEmptyCookie();
// modifyServerSuperGlobalVariable(__DIR__);

require_once 'bootstrap.php';
$addTest = new AddItemTest();
$addTest->testAddingSuccess();


/*
$addTest = new AddItemTest();
$addTest->setUp();
$addTest->testAddingSuccess();
$addTest->tearDown();

$addTest->setUp();
$addTest->testAddingSecond();
$addTest->tearDown();

$addTest->setUp();
$addTest->testAddingFailure();
$addTest->tearDown();


$editTest = new EditItemTest();
$editTest->setUp();
$editTest->testUpdatingSuccess();
$editTest->tearDown();

$editTest->setUp();
$editTest->testUpdatingFailure();
$editTest->tearDown();


$getListTest = new GetListTest();
$getListTest->setUp();
$getListTest->testGetListFailure();
$getListTest->tearDown();

$getListTest->setUp();
$getListTest->testGetListSuccess();
$getListTest->tearDown();


$deleteTest = new DeleteItemTest();
$deleteTest->setUp();
$deleteTest->testDeleteSuccess();
$deleteTest->tearDown();

$deleteTest->setUp();
$deleteTest->testDeleteFailure();
$deleteTest->tearDown();

*/