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

function redirectRelative($file) {
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header('Location: http://'.$host.$uri.'/'.$file);
}

/**
 * need to check if auth credentials are set differently...
 * if cookie is empty, include (or could redirect) login.php 
 *
 * or could do `include 'login.php'; die();`
 */
if (empty($_COOKIE)) {
    redirectRelative('login.php');
    return;
}

/**
 * only for the Auth
 */
if (session_status() !== PHP_SESSION_ACTIVE) 
    session_start();

// to remove excess redirect stuff
function modifyServerSuperGlobalVariable() {
    // change back slash to forward slash - only on windows
    $__DIR__ = str_replace('\\', '/', __DIR__);

    // take the (DOCUMENT_ROOT) & the (current folder out) of (__DIR__)
    $remove = str_replace([$_SERVER['DOCUMENT_ROOT']], "", $__DIR__);
    $remove = strtolower($remove);

    // take the (DOCUMENT_ROOT) out of the (REQUEST_URI) & (REDIRECT_URL)
    $_SERVER['REQUEST_URI'] = str_replace($_SERVER['DOCUMENT_ROOT'], "", $_SERVER['REQUEST_URI']);
    $_SERVER['REDIRECT_URL'] = str_replace($_SERVER['DOCUMENT_ROOT'], "", $_SERVER['REDIRECT_URL']);

    // make them lowercase
    $_SERVER['REQUEST_URI'] = strtolower($_SERVER['REQUEST_URI']);
    $_SERVER['REDIRECT_URL'] = strtolower($_SERVER['REDIRECT_URL']);

    // replace part of the directory with nothing
    $_SERVER['REQUEST_URI'] = str_replace($remove, "", $_SERVER['REQUEST_URI']);
    $_SERVER['REDIRECT_URL'] = str_replace($remove, "", $_SERVER['REDIRECT_URL']);  
}
modifyServerSuperGlobalVariable();

/**
 * alternatively, Dotenv::load(dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env');
 */
Dotenv::load([
    'filepath' => dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env',
    'toEnv' => true,
]);

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

function adr() 
{
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

/**
 * the key(s) of $input the second param
 * route @param #1 has to be unique
 */
$adr->post('Todo\DeleteItem', '/todo/delete/{id}', 'Todo\Action\DeleteItem') 
    ->responder('Todo\Responder\DeleteItemResponder')
;

$adr->get('Todo\DeleteItem\Get', '/todo/delete/{id}', 'Todo\Action\DeleteItem') 
    ->responder('Todo\Responder\DeleteItemResponder')
;
$adr->delete('Todo\DeleteItem\Delete', '/todo/delete/{id}', 'Todo\Action\DeleteItem') 
    ->responder('Todo\Responder\DeleteItemResponder')
;

$adr->get('Todo\AddItem\Get', '/todo/add/{description}', 'Todo\Action\AddItem')
    ->input('Todo\Input\AddItemInput')
    ->responder('Todo\Responder\AddItemResponder')
;

$adr->get('Todo\GetList\Get', '/todo/getlist/{userId}', 'Todo\Action\GetList') 
    ->input('Todo\Input\GetListInput')
    ->responder('Todo\Responder\AddItemResponder')
;

// added get route first, post did not work - see if it works on yours
$adr->get('Todo\EditItem\Get', '/todo/edit/{todoId}/{description}', 'Todo\Action\EditItem') 
    ->responder('Todo\Responder\EditItemResponder')
;
$adr->post('Todo\EditItem\Post', '/todo/edit/{todoId}/{description}', 'Todo\Action\EditItem')
    // ->input('Todo\Input\EditItemInput') /// this does not work...
    ->responder('Todo\Responder\EditItemResponder')
;

/*
    Could also be done inline like this
    (Domain could even be done like this if you wanted to manually inject or define dependencies in the .Config)

    $adr->get('Todo\AddItem\Get', '/todo/add/{description}', 'Todo\Action\AddItem')
        ->input(function ($request) {
            return [$request->getQueryParams()['description']];
        })
        ->responder(function ($request, $response, $payload) {
            $response->getBody()->write($payload);
            return $response;
        })
    ;
 */

/**
 * Run
 */
$adr->run(ServerRequestFactory::fromGlobals(), new Response());