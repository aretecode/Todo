<?php


function includeIndex() {
    include('../web/index.php');
}

require '../vendor/autoload.php';

use Aura\Di\ContainerBuilder;
class Boot extends RadarBoot
{
    // only added this so that it would auto resolve
    protected function newContainer(array $config)
    {
        $config = array_merge(['Radar\Adr\Config'], $config);
        return (new ContainerBuilder())->newConfiguredInstance($config, true);
    }
}

/**
 * only for the Auth
 */
if (session_status() === PHP_SESSION_ACTIVE) 
    session_start();

/**
 * alternatively, Dotenv::load(dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env');
 */
Dotenv::load([
    'filepath' => dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env',
    'toEnv' => true,
]);

function adr() {
    $boot = new Boot();

    /**
     *  this parameter is [optional]
     *  $boot->newContainer is private
     *  remember, the class can be named anything that makes sense in your ubiquitous language
     *  ['Radar\Adr\Config'] is auto merged
     */
    $adr = $boot->adr([
        'Web\Config',
    ]);

    /**
     * Middleware
     */
    $adr->middle(new ResponseSender());
    $adr->middle(new ExceptionHandler(new Response()));
    $adr->middle('Radar\Adr\Handler\RoutingHandler');
    $adr->middle('Radar\Adr\Handler\ActionHandler');

    return $adr;
}


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

// $getItemTest, $userTest