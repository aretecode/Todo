<?php

namespace Todo\Input;

use Psr\Http\Message\ServerRequestInterface as Request;
use Radar\Adr\Input;

class AddItemInput extends Input
{
    public function __invoke(Request $request)
    {    	
        return $request->getAttribute('description');
    }
}
