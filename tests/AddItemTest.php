<?php

namespace Todo;

class AddItemTest extends AbstractTest
{
    protected function setUpRoute() 
    {       
        /*
        $this->adr->put('Todo\AddItem\Put', '/todo/add/{description}', 'Todo\Action\AddItem') 
            ->input('Todo\Input\AddItemInput')
            ->responder('Todo\Responder\AddItemResponder');
        */
       
        $this->adr->get('Todo\AddItem\Post', '/todo/add/{description}', 'Todo\Action\AddItem') 
            ->input('Todo\Input\AddItemInput')
            ->responder('Todo\Responder\AddItemResponder');
    }

    public function testAddingSuccess() 
    {                  
        ob_start();        
        //echo "\nsetUp\n";
        $this->setUpADR();
        $this->setUpRoute();
     
        $description = rand(0, 100000000) . ' :-)';
        $request = $this->newRequest('/todo/add/'.$description); // , 'GET'
        $response = $this->responseFromRun();
        $this->assertRelayResponse($response, 201, ['Content-Type' => ['application/json']], '{"description":"'.$description.'"}'); 
        $todo = $this->mostRecentTodo();                

        echo "\ntoreDown\n";
        $this->output .= PHP_EOL . ob_get_clean();
        fwrite(STDOUT, $this->output . "\n");
    }      

    /*
    public function testAddingSecond() 
    {        
        $description = rand(0, 100000000) . ' :-)';
        $request = $this->newRequest('/todo/add/'.$description); 
        $response = $this->responseFromRun();
        $this->assertRelayResponse($response, 201, ['Content-Type' => ['application/json']], '{"description":"'.$description.'"}');
        $todo = $this->mostRecentTodo(); 
    }


    /**
     * @TODO: BecauseItAlreadyExists && BecauseInvalid /// 500, 405
     * /
    public function testAddingFailure() 
    {          
        // getting most recent so we are trying to insert something that already exists
        $todo = $this->mostRecentTodo(); 
        $description = $todo['description'];
        $request = $this->newRequest('/todo/add/'.$description);

        $response = $this->responseFromRun();
        
        $this->assertRelayResponse($response, 400, ['Content-Type' => ['application/json']], '["a Todo with the same Description was found",{"description":"'.$description.'"}]');
    }  
    */  
}