<?php

// Home URL
function home(){    
    require('config.php');
    return (empty($config['APP_SLUG']))? $config['APP_URL'] : $config['APP_URL'].$config['APP_SLUG'];
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
    $url = (empty($config['APP_SLUG']))?substr(explode("?", $_SERVER['REQUEST_URI'])[0], 1):substr(explode("?", $_SERVER['REQUEST_URI'])[0], strlen($config['APP_SLUG'])+2);
    require('config.php');
    $url = (empty($url))? home():home()."/".$url;  
    return $url;
}

