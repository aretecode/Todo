<?php

namespace Web;

use Aura\Di\Container;
use Aura\Di\ContainerConfig;

class Config extends ContainerConfig
{
    public function define(Container $di)
    {
        /*
            should it be done defining them manually, or auto?
            why can't a trait be set?

            $u = User();
            $m = new \Domain\Todo\Mapper;
            $t = new \Domain\Todo\TodoEntity;
            $p = new \Aura\Payload\Payload();

            $di->params['Domain\Todo\ApplicationService\EditItem']['user'] = $u;
            $di->params['Domain\Todo\ApplicationService\EditItem']['mapper'] = $m;
            $di->params['Domain\Todo\ApplicationService\EditItem']['payload'] = $p;

            $di->params['Domain\Todo\ApplicationService\AddItem']['user'] = $u;
            $di->params['Domain\Todo\ApplicationService\AddItem']['mapper'] = $m;
            $di->params['Domain\Todo\ApplicationService\AddItem']['payload'] = $p;

            $di->params['Domain\Todo\ApplicationService\GetList']['user'] = $u;
            $di->params['Domain\Todo\ApplicationService\GetList']['mapper'] = $m;
            $di->params['Domain\Todo\ApplicationService\GetList']['payload'] = $p;
           
            $di->params['Domain\Todo\ApplicationService\DeleteItem']['user'] = $u;
            $di->params['Domain\Todo\ApplicationService\DeleteItem']['mapper'] = $m;
            $di->params['Domain\Todo\ApplicationService\DeleteItem']['payload'] = $p;
        */       

        ////////////////////////////////////
        // NONE OF THESE WORK      
        // todo/DeleteItem
        // todo:deleteitem
        // delete_item
        ////////$di->set('delete_item', $di->lazyNew('Domain\Todo\ApplicationService\DeleteItem'));
        ////////$di->types['Mapper'] = $di->lazyGet('delete_item');
        // $di->types['Domain\Todo\Mapper'] = $di->lazyGet('Domain\Todo\Mapper');
        /*
            $di->set('service_name', $di->lazyNew(
                'ExampleWithParams',
                array(
                    'bar' => 'alternative_bar_value',
                )
            ));
        */
        // especially this one...
        // $di->params['Domain\Todo\ApplicationService\Mapper']['ExtendedPdo'] = $di->lazyNew('Aura\Sql\ExtendedPdo', ['dsn' => $database_handle]);


        ////////////////////////////////////
        /// wanted to set the autoresolve to magic here but couldn't seem to
        // $di->params['Domain\Todo\Mapper']['map'] = $di->lazyGetCall('radar/adr:router', 'getMap');
        // $di->set('Domain\Todo\ApplicationService\DeleteItem', $di->lazyNew('Domain\Todo\ApplicationService\DeleteItem'));
        // $di->set('\Domain\Todo\ApplicationService\DeleteItem', $di->lazyNew('\Domain\Todo\ApplicationService\DeleteItem'));
        // $di->setters['Aura\Router\RouterContainer']['setRouteFactory'] = $di->newFactory('Radar\Adr\Route');
        ////////////////////////////////////
        
        // could do Todo_database_handle & Account_database_handle
        $database_handle = new \PDO($_ENV['DB_DSN'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);  #connection
        $di->params['Aura\Sql\ExtendedPdo']['dsn'] = $database_handle;

        ///     
        $di->set('aura/payload', $di->lazyNew('Aura\Payload\Payload'));

        ///
        $di->set('user', $di->lazyNew('Domain\User\User'));
        $di->types['User'] = $di->lazyGet('user');
    }
}

