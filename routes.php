<?php
require('router.php');

        $router = new Router($_SERVER);


        $router->addRoute('', 'views/index.php');
        

        $router->addRoute('test','views/test.php');
        $router->addRoute('lyrics','views/lyrics.php');
            
        
        /* Auth Routes */
            
        $router->addRoute('login','views/auth/login.php');


        /*API Routes*/  
        $router->addRoute('api/example','api/example.php');
        

        

        /* Run Routes */
        $router->run();

        