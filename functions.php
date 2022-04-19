<?php
//Get ENV
// Home URL
function home(){    
    require('config.php');
    return $config['APP_URL'];
}
// Get URL Parameters
      
// Get URl
function url(){
    require('config.php');
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $url = "https://";   
    else  
         $url = "http://";   
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];   
    
    // Append the requested resource location to the URL   
    $url.= $_SERVER['REQUEST_URI'];    
    $url = ($config['APP_MODE']=='production')?substr(explode("?", $_SERVER['REQUEST_URI'])[0], 1):substr(explode("?", $_SERVER['REQUEST_URI'])[0], strlen($config['APP_TESTING_ROOT'])+2);
    require('config.php');
    return $config['APP_URL'].$url;  
}

