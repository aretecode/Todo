<?php

namespace Todo;

use PDO;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Relay\Middleware\ExceptionHandler;
use Relay\Middleware\ResponseSender;
use Web\Boot;

abstract class AbstractTest extends \PHPUnit_Framework_TestCase {
    public $adr;
    protected $output;

    public function setup() {
        ob_start();
        $this->setUpADR();
        $this->setUpRoute();
    }

    public function setUpADR() {
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
        $this->assertEquals($expectStatus, $response->getStatusCode(), 'expected status did not match');
        $this->assertEquals($expectBody, $response->getBody()->__toString(), 'expected body did not match');
        $this->assertEquals($expectHeaders, $response->getHeaders(), 'expected headers did not match');
    }         
    protected function assertRelayResponse($response, $expectStatus, $expectHeaders, $expectBody)
    {
        $this->assertEquals($expectBody, $response->getBody()->__toString(), 'expected body did not match');
        $this->assertEquals($expectStatus, $response->getStatusCode(), 'expected status did not match');
        $this->assertEquals($expectHeaders, $response->getHeaders(), 'expected headers did not match');
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

    protected function tearDown()
    {
        echo "eh?";        
        $this->output .= PHP_EOL . ob_get_clean();
        fwrite(STDOUT, $this->output . "\n");
    }
}
