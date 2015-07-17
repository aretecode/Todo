<?php

namespace Domain;

use Aura\Payload\Payload;
use Domain\User\ApplicationService\UserService;
use Domain\Todo\ApplicationService\AddItem; // CreateItem
use Domain\Todo\ApplicationService\EditItem;
use Domain\Todo\ApplicationService\GetItem;
use Domain\Todo\ApplicationService\GetList;
use Domain\Todo\ApplicationService\DeleteItem;

/**
 * This is more of an ApplicationService (albeit, it may resemble a Facade), in ADR I think of D(omain) as S(ervice) layer.
 * Alternatively, the UserService could be injected into the TodoService, but that seems bad.
 */
class Domain 
{
    protected $addItem;     // create
    protected $getItem;     // read
    protected $getList;     // read
    protected $editItem;    // updated
    protected $deleteItem;  // delete
    protected $userService;

    public function __construct(
        AddItem $addItem,
        DeleteItem $deleteItem,
        EditItem $editItem,
        GetItem $getItem,
        GetList $getList,
        UserService $userService
    ) {
        $this->addItem = $addItem;
        $this->editItem = $editItem;
        $this->getItem = $getItem;
        $this->getList = $getList;
        $this->deleteItem = $deleteItem;
        $this->userService = $userService;
    }

    // could also do these automagically
    public function add($description, $userId) 
    {
        if ($payload = $this->isUserNotAuthenticatedPayload()) 
            return $payload; 
        return $this->addItem->add($description, $userId);
    }
    public function delete($todoId) 
    {
        if ($payload = $this->isUserNotAuthenticatedPayload()) 
            return $payload; 
        return $this->deleteItem->delete($todoId);
    }
    public function edit($todoId, $userId, $newDescription)
    {
    	if ($payload = $this->isUserNotAuthenticatedPayload()) 
    		return $payload; 
    	return $this->editItem->edit($todoId, $userId, $newDescription);
    }
    public function todoWithId($todoId) 
    {
    	if ($payload = $this->isUserNotAuthenticatedPayload()) 
    		return $payload; 
    	return $this->getItem->todoWithId($todoId);
    }
    public function listForUserId($todoId) 
    {
    	if ($payload = $this->isUserNotAuthenticatedPayload()) 
    		return $payload; 
    	return $this->getList->listForUserId($todoId);
    }

    // user
    public function isUserNotAuthenticatedPayload() 
    {
    	return $this->userService->isUserNotAuthenticatedPayload();
    }
    // pass in User
    public function currentUser() 
    {
    	return $this->userService->currentUser();
    }
}