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

        // could do Todo_database_handle & Account_database_handle

        if (isset($_ENV['DB_DSN'])) {
            $db = $_ENV['DB_DSN'];
            $username = $_ENV['DB_USERNAME'];
            $pass = $_ENV['DB_PASSWORD'];
        }
        else {
            $db = getenv('DB_DSN');
            $username = getenv('DB_USERNAME');
            $pass = getenv('DB_PASSWORD');
        }

        $database_handle = new \PDO($db, $username, $pass);  #connection
        $di->params['Aura\Sql\ExtendedPdo']['dsn'] = $database_handle;

        ///     
        $di->set('aura/payload', $di->lazyNew('Aura\Payload\Payload'));

        ///
        $di->set('user', $di->lazyNew('Domain\User\User'));
        $di->types['User'] = $di->lazyGet('user');

        $di->params['Aura\Auth\AuthFactory']['cookie'] = $_COOKIE;
        $di->params['Aura\Auth\Verifier\PasswordVerifier']['algo'] = PASSWORD_DEFAULT; // should be optional

    }
}

