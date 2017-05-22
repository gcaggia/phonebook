<?php

use Phalcon\Loader;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;
use Phalcon\Flash\Direct as FlashDirect;

try {
    
    // Register the loader component
    $loader = new Loader();
    $loader->registerDirs(array(
        '../app/controllers',
        '../app/models'
    ))->register();
    
    // DI Container
    $di = new FactoryDefault();
    
    // Connect with the db
    $di->set('db', function() {
        return new PdoMysql(Array(
            'host'     => 'localhost',
            'username' => 'root',
            'password' => 'root',
            'dbname'   => 'phonebook'
        ));
    });
    
    // Register the view service
    $di->set('view', function() {
        $view = new View();
        $view->setViewsDir('../app/views');
        
        require_once '../support/helpers.php';
        
        return $view;
    });
    
    // Register the flash service with custom CSS classes
    $di->set(
        "flash",
        function () {
            $flash = new FlashDirect(
                [
                    "error"   => "alert alert-danger",
                    "success" => "alert alert-success",
                    "notice"  => "alert alert-info",
                    "warning" => "alert alert-warning",
                ]
            );
            
            // Change autoescape to false
            $flash->setAutoescape(false); 

            return $flash;
        }
    );
    
    // Register the URL service 
    $di['url'] = function() {
        $url = new UrlProvider();
        $url->setBaseUri('/');
        return $url;
    };
    
    // handle requests
    $app = new Application($di);
    echo $app->handle()->getContent();
    
} catch( \Exception $e) {
    echo "Exception: ", $e->getMessage();
}
