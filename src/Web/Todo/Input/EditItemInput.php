<?php

namespace Todo\Input;

use Psr\Http\Message\ServerRequestInterface;

class EditItemInput
{
    public function __invoke(ServerRequestInterface $request)
    {    	
    	// return ['todoId' => $request->getQueryParams()['todoId'], 'description' => $request->getQueryParams()['description']];
    	// return [$request->getQueryParams()['todoId'], $request->getQueryParams()['description']];

        $todoId = $request->getAttribute('todoId');
        $description = $request->getAttribute('description');
        return array('todoId' => $todoId, 'description' => $description);
    }
}