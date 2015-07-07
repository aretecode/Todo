<?php

namespace Todo;

class GetListTest extends AbstractTest 
{
    protected function setUpRoute() 
    {
        $this->adr->get('Todo\GetList\Get', '/todo/getlist/{userId}', 'Todo\Action\GetList') 
            ->input('Todo\Input\GetListInput')
            ->responder('Todo\Responder\GetItemResponder')
        ;
    }

    /**
     * @TODO: need to assert response here, should it get from db?
     */
    public function testGetListSuccess() 
    {              
        $userId = 1;
        $request = $this->newRequest('/todo/getlist/'.$userId);
        $response = $this->responseFromRun();
    }    

    /**
     * aka not found for UserId
     */
    public function testGetListFailure() 
    {             
        $failingUserId = "-1";
        $request = $this->newRequest('/todo/getlist/'.$failingUserId);
        $response = $this->responseFromRun(); 

        // no headers?
        //   ["reasonPhrase":"Zend\Diactoros\Response":private]=  string(9) "Not Found"
        $this->assertRelayResponse($response, 404, [], "");
    }    
}