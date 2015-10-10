<?php

namespace Todo;

class DeleteItemTest extends AbstractTest 
{
    protected function setUpRoute() 
    {        
        // ->input('Todo\Input\EditItemInput')
        $this->adr->get('Todo\DeleteItem\Get', '/todo/delete/{id}', 'Todo\Action\DeleteItem') 
            ->responder('Todo\Responder\DeleteItemResponder');
    }

    /**
     *  HOW TO MERGE $REQUEST AND THE $_GET? 
     *  303
     */
    public function testDeleteSuccess() 
    {            
        $todoId = $this->mostRecentEntryId();
        $request = $this->newRequest('/todo/delete/'.$todoId);
        $response = $this->responseFromRun();
        $this->assertRelayResponse($response, 204, ['Content-Type' => ['application/json']], '{"id":"'.$todoId.'"}');
    }    

    /**
     * @TODO:
     * UserId did not match
     * testUpdatingNotFound + one for Failure with 500 '{"error":"Unknown domain payload status","status":"NOT_DELETED"}'
     */
    public function testDeleteFailure() 
    {             
        $failingTodoId = "-1";
        $request = $this->newRequest('/todo/delete/'.$failingTodoId);
        $response = $this->responseFromRun(); // 404
     
        $responseString = '{"status":"NOT_FOUND", "todoId":"'. $failingTodoId.'"}';
        $responseString = addslashes($responseString);
        $responseString = '"'.$responseString.'"';

        // , 'Allow' => [$method]
        $this->assertRelayResponse($response, 404, ['Content-Type' => ['application/json']], $responseString);
    }    
}