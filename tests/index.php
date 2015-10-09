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
$redirectPayload = redirectOnEmptyCookie();
modifyServerSuperGlobalVariable(__DIR__);

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
