<?php
require('router.php');

        $router = new Router($_SERVER);


        $router->addRoute('/', 'views/index.php');
        
        $router->addRoute('hello','views/test.php');

        $router->addRoute('test','views/test.php');
        
        
            
        
            

        /*API Routes*/  
        $router->addRoute('api/example','api/example.php');
        

        

        /* Run Routes */
        $router->run();
