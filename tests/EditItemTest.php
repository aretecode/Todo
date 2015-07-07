<?php

namespace Todo;

class EditItemTest extends AbstractTest 
{
    protected function setUpRoute() 
    {
        $this->adr->get('Todo\EditItem\Get', '/todo/edit/{todoId}/{description}', 'Todo\Action\EditItem') 
            // ->input('Todo\Input\EditItemInput')
            ->responder('Todo\Responder\EditItemResponder');
    }

    public function testUpdatingSuccess() 
    {        
        $todoId = $this->mostRecentEntryId();
        $newDescription = 'Hullabaloo! Hephalumps & Woozles.';
        $request = $this->newRequest('/todo/edit/'.$todoId.'/'.$newDescription);
        $response = $this->responseFromRun();
        $this->assertRelayResponse($response, 303, ['Content-Type' => ['application/json']], '{"description":"'.$newDescription.'"}');
    }    

    /**
     * @TODO: testUpdatingNotFound + one for Failure with 500
     */
    public function testUpdatingFailure() 
    {        
        $failingTodoId = "-1";        
        $newDescription = 'Hullabaloo! Hephalumps & Woozles.';
        $request = $this->newRequest('/todo/edit/'.$failingTodoId.'/'.$newDescription);
        $response = $this->responseFromRun(); // 404

        // could also strip the slashes from the ~`'"input"'`~
        $responseString = '{"status":"NOT_FOUND", "todoId":"'. $failingTodoId.'"}';
        $responseString = addslashes($responseString);
        $responseString = '"'.$responseString.'"';

        $this->assertRelayResponse($response, 404, ['Content-Type' => ['application/json']], $responseString );
    }    
}