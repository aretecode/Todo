<?php

namespace Todo\Responder;

use Web\AbstractResponder;

use Radar\Adr\Responder\Responder;

abstract class AbstractTodoResponder extends Responder
{
    // from example-code
    /*
        protected function init()
        {
            parent::init();
            $view_names = array(
                'browse',
                'browse.json',
                'read',
                'read.json',
                'edit',
                'add',
                'delete-failure',
                'delete-success',
                '_form',
                '_intro',
            );
            $view_registry = $this->view->getViewRegistry();
            foreach ($view_names as $name) {
                $view_registry->set(
                    $name,
                    __DIR__ . "/views/{$name}.php"
                );
            }
        }
    */

    protected $view;
    protected function renderView($view)
    {
        $view_factory = new \Aura\View\ViewFactory;
        $this->view = $view_factory->newInstance();

        $this->view->setView($view);
        
        $this->response->withBody($this->view->__invoke());
    }
}
