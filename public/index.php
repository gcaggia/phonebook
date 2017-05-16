<?php

use Phalcon\Loader;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Url as UrlProvider;

try {
    
    // Register the loader component
    $loader = new Loader();
    $loader->registerDirs(array(
        '../app/controllers',
        '../app/models'
    ))->register();
    
    // DI Container
    $di = new FactoryDefault();
    
    // Register the view service
    $di->set('view', function() {
        $view = new View();
        $view->setViewsDir('../app/views');
        return $view;
    });
    
    // Register the URL service 
    $di['url'] = function() {
        $url = new UrlProvider();
        $url->setBaseUri('/phonebook/');
        return $url;
    };
    
    // handle requests
    $app = new Application($di);
    echo $app->handle()->getContent();
    
} catch( \Exception $e) {
    echo "Exception: ", $e->getMessage();
}
