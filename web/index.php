<?php

use josegonzalez\Dotenv\Loader as Dotenv;
use Radar\Adr\Boot as RadarBoot;
use Radar\Adr\Route; // I added // @15/06/15-10:37
use Radar\Adr\Responder\Responder;

use Relay\Middleware\ExceptionHandler;
use Relay\Middleware\ResponseSender;
use Zend\Diactoros\Response as Response;
use Zend\Diactoros\ServerRequestFactory;

use Domain\Todo\ApplicationService\EditItem;

/**
 * Bootstrapping - could put in bootstrap.php from here.........
 */
require_once "C:/xampp/htdocs/Master/DOCROOT.php";
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
/**
 * ......... to here
 */

$adr = adr();
// @todo: 2 copies, one with services all in one, one with them split up

// the key(s) of $input the second param 
// route @param #1 has to be unique
$adr->post('Todo\DeleteItem', '/todo/delete/{id}', 'Todo\Action\DeleteItem') //;
    ->responder('Todo\Responder\DeleteItemResponder')
;

$adr->get('Todo\DeleteItem\Get', '/todo/delete/{id}', 'Todo\Action\DeleteItem') //;
    ->responder('Todo\Responder\DeleteItemResponder')
;
$adr->get('Todo\AddItem\Get', '/todo/add/{description}', 'Todo\Action\AddItem') //;
    ->input('Todo\Input\AddItemInput')
    ->responder('Todo\Responder\AddItemResponder')
;

$adr->get('Todo\GetList\Get', '/todo/getlist/{userId}', 'Todo\Action\GetList') //;
    ->input('Todo\Input\GetListInput')
    ->responder('Todo\Responder\AddItemResponder')
;

$adr->post('Todo\EditItem\Post', '/todo/edit/{todoId}/{description}', 'Todo\Action\EditItem') //;
    // ->input('Todo\Input\EditItemInput') /// this does not work...
    ->responder('Todo\Responder\EditItemResponder')
;

/**
 * Run
 */
$adr->run(ServerRequestFactory::fromGlobals(), new Response());
