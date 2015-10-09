<?php

use josegonzalez\Dotenv\Loader as Dotenv;
use Radar\Adr\Route; 
use Radar\Adr\Responder\Responder;

use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;

use Domain\Todo\ApplicationService\EditItem;
use Web\AdrFactory;

// require_once "C:/xampp/htdocs/Master/DOCROOT.php";
// require '../vendor/autoload.php';
require_once __DIR__.'/../vendor/autoload.php';

startSession();
$redirectPayload = redirectOnEmptyCookie();
modifyServerSuperGlobalVariable(__DIR__);
loadDotEnv(__DIR__);

$adr = AdrFactory::create();


/**
 * the key(s) of $input the second param
 * route @param #1 has to be unique
 */

/*
$adr->post('Todo\DeleteItem', '/todo/delete/{id}', 'Todo\Action\DeleteItem') 
    ->responder('Todo\Responder\DeleteItemResponder');

$adr->get('Todo\DeleteItem\Get', '/todo/delete/{id}', 'Todo\Action\DeleteItem') 
    ->responder('Todo\Responder\DeleteItemResponder');

$adr->delete('Todo\DeleteItem\Delete', '/todo/delete/{id}', 'Todo\Action\DeleteItem') 
    ->responder('Todo\Responder\DeleteItemResponder');

Domain\Todo\ApplicationService\AddItem
*/

$adr->get('Todo\AddItem\Get', '/todo/add/{description}', 'Todo\Action\AddItem')
    ->input('Todo\Input\AddItemInput')
    ->responder('Todo\Responder\AddItemResponder');

$adr->get('Todo\GetList\Get', '/todo/getlist/{userId}', 'Todo\Action\GetList') 
    ->input('Todo\Input\GetListInput')
    ->responder('Todo\Responder\AddItemResponder');

// added get route first, post did not work - see if it works on yours
$adr->get('Todo\EditItem\Get', '/todo/edit/{todoId}/{description}', 'Todo\Action\EditItem') 
    ->responder('Todo\Responder\EditItemResponder');

$adr->post('Todo\EditItem\Post', '/todo/edit/{todoId}/{description}', 'Todo\Action\EditItem')
    // ->input('Todo\Input\EditItemInput') /// this does not work...
    ->responder('Todo\Responder\EditItemResponder');

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
