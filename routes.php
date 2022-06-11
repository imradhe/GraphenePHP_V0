<?php
require('router.php');

        $router = new Router($_SERVER);


        $router->addRoute('', 'views/index.php');
        $router->addRoute('/', 'views/index.php');
        

        
        $router->addRoute('search','views/search.php');
        $router->addRoute('rent','views/rent.php');

        $router->addRoute('profile','views/profile.php');


        //Customer Routes
        $router->addRoute('register/customer','views/register/customer.php');
        $router->addRoute('profile/customer','views/profile/customer.php');

        // Host Routes
        $router->addRoute('register/host','views/register/host.php');
        $router->addRoute('profile/host','views/profile/host.php');
        $router->addRoute('host/bookings','views/host/bookings.php');
        
        //Car Routes
        $router->addRoute('cars/new','views/cars/new.php');
        $router->addRoute('cars/edit','views/cars/edit.php');

        $router->addRoute('test','views/test.php');
            
        
        /* Auth Routes */
            
        $router->addRoute('login','views/auth/login.php');
        
        $router->addRoute('logout','views/auth/logout.php');

        /*API Routes*/  
        $router->addRoute('api/example','api/example.php');
        $router->addRoute('api/logs','api/logs.php');
        $router->addRoute('api/test','api/test.php');
        $router->addRoute('api/login','api/auth/login.php');
        $router->addRoute('api/logout','api/auth/logout.php');
        
        
        
        /* Run Routes */
        $router->run();

        