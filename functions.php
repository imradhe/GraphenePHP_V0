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
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $url = "https://";   
    else  
         $url = "http://";   
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];   
    
    // Append the requested resource location to the URL   
    $url.= $_SERVER['REQUEST_URI'];    
    $url = substr(explode("?", $_SERVER['REQUEST_URI'])[0], 13);
    $url = substr($url,1);
    require('config.php');
    return $config['APP_URL'].$url;  
}

