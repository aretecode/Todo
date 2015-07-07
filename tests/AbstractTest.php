<?php

namespace Todo;

use PDO;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Relay\Middleware\ExceptionHandler;
use Relay\Middleware\ResponseSender;

abstract class AbstractTest extends PHPUnit_Framework_TestCase {
    protected $adr;

    public function setUp()
    {
        $this->setUpADR();
        $this->setUpRoute();
    }

    protected function setUpADR() {
        $boot = new Boot();

        $adr = $boot->adr([
            'Web\Config',
        ]);

        $adr->middle(new ResponseSender());
        $adr->middle(new ExceptionHandler(new Response()));
        $adr->middle('Radar\Adr\Handler\RoutingHandler');
        $adr->middle('Radar\Adr\Handler\ActionHandler');

        $this->adr = $adr;
    }

    protected function newAction($input, $domain, $responder)
    {
        return $this->actionFactory->newInstance($input, $domain, $responder);
    }
    protected function newRequest($path)
    {
        $_SERVER['REQUEST_URI'] = $path;
        return ServerRequestFactory::fromGlobals();
    }
    protected function assertResponse(Action $action, $expectStatus, $expectHeaders, $expectBody)
    {
        $request = ServerRequestFactory::fromGlobals();
        $request = $request->withAttribute('radar/adr:action', $action);
        $response = $this->actionHandler->__invoke(
            $request,
            new Response(),
            function ($request, $response) { return $response; }
        );
        $this->assertEquals($expectStatus, $response->getStatusCode());
        $this->assertEquals($expectBody, $response->getBody()->__toString());
        $this->assertEquals($expectHeaders, $response->getHeaders());
    }         
    protected function assertRelayResponse($response, $expectStatus, $expectHeaders, $expectBody)
    {
        $this->assertEquals($expectBody, $response->getBody()->__toString());
        $this->assertEquals($expectStatus, $response->getStatusCode());
        $this->assertEquals($expectHeaders, $response->getHeaders());
    }       
    protected function responseFromRun() {
        return $response = $this->adr->run(ServerRequestFactory::fromGlobals(), new Response());
    }

    // 
    public function mostRecentEntryId() {
        $database_handle = new PDO($_ENV['DB_DSN'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']); 
        $statement_handle = $database_handle->query("SELECT `todoId` FROM `todo` ORDER BY `todoId` DESC LIMIT 1");
        $result = $statement_handle->fetch();

        $todoId = $result[0];
        return $todoId;
    }

    public function mostRecentTodo() {
        $database_handle = new PDO($_ENV['DB_DSN'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
        $statement_handle = $database_handle->query("SELECT * FROM `todo` ORDER BY `todoId` DESC LIMIT 1");
        $todo = $statement_handle->fetch();

        return $todo;
    }
}
