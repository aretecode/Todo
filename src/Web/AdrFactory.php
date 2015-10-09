<?php

namespace Web;

use Relay\Middleware\ExceptionHandler;
use Relay\Middleware\ResponseSender;
use Zend\Diactoros\Response;

class AdrFactory {
    public static function create()
    {
        $boot = new Boot();

        /**
         *  this parameter is [optional]
         *  $boot->newContainer is private
         *  remember, the class can be named anything that makes sense in your ubiquitous language
         *  ['Radar\Adr\Config'] is auto merged
         */
        $adr = $boot->adr([
            'Web\Config',
        ]);

        /**
         * Middleware
         */
        $adr->middle(new ResponseSender());
        $adr->middle(new ExceptionHandler(new Response()));
        $adr->middle('Radar\Adr\Handler\RoutingHandler');
        $adr->middle('Radar\Adr\Handler\ActionHandler');

        return $adr;
    }
}

