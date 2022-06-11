<?php

// Home URL
function home(){    
    require('config.php');
    return (empty($config['APP_SLUG']))? $config['APP_URL'] : $config['APP_URL'].$config['APP_SLUG']."/";
}
      
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
    $url = (empty($url))? home():home().$url;  
    return $url;
}

// Lock a file
function locked($role = 'customer'){
  controller("Auth");
  $auth = new Auth();
  if(empty(getSession())){
    redirectIfLocked(); 
  }elseif(getUser()['role'] != $role){
    redirectIfLocked();
  }
}


function redirectIfLocked(){
  if(url() != route("login")) header("Location:".route("login")."?back=".url().str_replace('&','$',queryString()));
}



function assets($path){
  echo home()."assets/".$path;
}

// Get url for a route
function route($path){
  return home().$path;
}

// Get Query String
function queryString(){
  return "?".$_SERVER['QUERY_STRING'];
}

// Get Complete URl
function getRoute(){
  return url()."?".$_SERVER['QUERY_STRING'];
}

// Add Controller
function controller($className){
  return require('controllers/'.$className.'Controller.php');
}

// Add API Controller
function APIController($className){
  return require('controllers/api/'.$className.'Controller.php');
}

function view($fileName){
  return require("views/".$fileName.".php");
}

// Convert currency value to INR
function strtoinr($price){ 
  $locale = 'hi';
  $currency = 'INR';
  $inr = new NumberFormatter($locale, NumberFormatter::CURRENCY);
  $price = (int)$price;
  $formattedPrice = $inr->formatCurrency($price, $currency);
  return substr($formattedPrice, 0, strlen($formattedPrice)-3);
}

// Get Current Session
function getSession(){
  $loginID = $_COOKIE['auth'];
  
  require("db.php");
  $query = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from logs where loginID='$loginID' and loggedout=0"));
  
  if($query){
    return $query;
  }
  else return false;
  }
  
// Get User from cookie
function getUser(){
  $loginID = $_COOKIE['auth'];

  require("db.php");
  $query = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from logs where loginID='$loginID' and loggedout=0"));

  if($query){
    $email = $query['email'];
    $currentLog = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from users where email='$email'"));
    return $currentLog;
  }
  else return false;
}


// Get Customer from cookie
function getCustomer(){
  $loginID = $_COOKIE['auth'];

  require("db.php");
  $query = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from logs where loginID='$loginID' and loggedout=0"));

  if($query){
    $email = $query['email'];
    $currentLog = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from customers where email='$email'"));
    return $currentLog;
  }
  else return false;
}

// Get Customer by ID
function getCustomerByID($customerID){

  require("db.php");
  
  return mysqli_fetch_assoc(mysqli_query($con,"SELECT * from customers where customerID='$customerID'"));
}

// Get car by ID
function getCar($carID){

  require("db.php");

  return mysqli_fetch_assoc(mysqli_query($con,"SELECT * from cars where carID='$carID' and status = 'available'"));
}

function getBookedCar($carID){

  require("db.php");

  return mysqli_fetch_assoc(mysqli_query($con,"SELECT * from cars where carID='$carID' and status = 'booked'"));
}

function getRemovedCar($carID){

  require("db.php");

  return mysqli_fetch_assoc(mysqli_query($con,"SELECT * from cars where carID='$carID' and status = 'removed'"));
}


function getHostByEmail($email){

  require("db.php");
  
  return mysqli_fetch_assoc(mysqli_query($con,"SELECT * from hosts where email='$email'"));
}

function getHost($hostID){

  require("db.php");
  
  return mysqli_fetch_assoc(mysqli_query($con,"SELECT * from hosts where hostID='$hostID'"));
}

function getBooking($bookingID){

  require("db.php");
  
  return mysqli_fetch_assoc(mysqli_query($con,"SELECT * from bookings where bookingID='$bookingID'"));
}


function getAuthorizationHeader(){
  $headers = null;
  if (isset($_SERVER['Authorization'])) {
      $headers = trim($_SERVER["Authorization"]);
  }
  else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
      $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
  } elseif (function_exists('apache_request_headers')) {
      $requestHeaders = apache_request_headers();
      // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
      $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
      //print_r($requestHeaders);
      if (isset($requestHeaders['Authorization'])) {
          $headers = trim($requestHeaders['Authorization']);
      }
  }
  return $headers;
}

/**
* get access token from header
* */
function getBearerToken() {
  $headers = getAuthorizationHeader();
  // HEADER: Get the access token from the header
  if (!empty($headers)) {
      if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
          return $matches[1];
      }
  }
  return null;
}
function getAPIToken() {
  $headers = null;
  if (isset($_SERVER['token'])) {
      $headers = trim($_SERVER["token"]);
  }
  elseif (isset($_SERVER['HTTP_TOKEN'])) {
      $headers = trim($_SERVER["HTTP_TOKEN"]);
  }
  elseif (isset($_SERVER['HTTP_ACCEPT'])) {
      $headers = trim($_SERVER["HTTP_ACCEPT"]);
  }
  elseif (function_exists('apache_request_headers')) {
      $requestHeaders = apache_request_headers();
      // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
      $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
      //print_r($requestHeaders);
      if (isset($requestHeaders['token'])) {
          $headers = trim($requestHeaders['token']);
      }
  }
  return $headers;
}

function sha256($string) {
  return hash('sha256', $string);
}

function sha512($string) {
  return hash('sha512', $string);
}


function sendRequest($url, $method, $fields){
  $curl = curl_init();

  curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => $method,
  CURLOPT_POSTFIELDS => $fields
  ));

  $response = curl_exec($curl);

  curl_close($curl);

  return $response;
}

function getOS() { 

  $user_agent = $_SERVER['HTTP_USER_AGENT'];


  $os_array     = array(
                        '/windows/i'      =>  'Windows',
                        '/Windows NT 11/i'      =>  'Windows 11',
                        '/Windows NT 10/i'      =>  'Windows 10',
                        '/windows nt 6.3/i'     =>  'Windows 8.1',
                        '/windows nt 6.2/i'     =>  'Windows 8',
                        '/windows nt 6.1/i'     =>  'Windows 7',
                        '/windows nt 6.0/i'     =>  'Windows Vista',
                        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                        '/windows nt 5.1/i'     =>  'Windows XP',
                        '/windows xp/i'         =>  'Windows XP',
                        '/windows nt 5.0/i'     =>  'Windows 2000',
                        '/windows me/i'         =>  'Windows ME',
                        '/win98/i'              =>  'Windows 98',
                        '/win95/i'              =>  'Windows 95',
                        '/win16/i'              =>  'Windows 3.11',
                        '/macintosh|mac os x/i' =>  'Mac OS X',
                        '/mac_powerpc/i'        =>  'Mac OS 9',
                        '/linux/i'              =>  'Linux',
                        '/ubuntu/i'             =>  'Ubuntu',
                        '/iphone/i'             =>  'iPhone',
                        '/ipod/i'               =>  'iPod',
                        '/ipad/i'               =>  'iPad',
                        '/android/i'            =>  'Android',
                        '/blackberry/i'         =>  'BlackBerry',
                        '/webos/i'              =>  'Mobile'
                  );

  foreach ($os_array as $regex => $value)
      if (preg_match($regex, $user_agent))
          $os_platform = $value;

  return $os_platform;
}


function getIP(){
      if (isset($_SERVER["HTTP_CLIENT_IP"])) {
          $ip = $_SERVER["HTTP_CLIENT_IP"];
      } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
          $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
      } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
          $ip = $_SERVER["HTTP_X_FORWARDED"];
      } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
          $ip = $_SERVER["HTTP_FORWARDED_FOR"];
      } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
          $ip = $_SERVER["HTTP_FORWARDED"];
      } else {
          $ip = $_SERVER["REMOTE_ADDR"];
      }

      // Strip any secondary IP etc from the IP address
      if (strpos($ip, ',') > 0) {
          $ip = substr($ip, 0, strpos($ip, ','));
      }
      return $ip;
}

function getDevice(){ 
  $u_agent = $_SERVER['HTTP_USER_AGENT'];
  $bname = 'Unknown';
  $platform = 'Unknown';
  $version= "";

  //First get the platform?
  if (preg_match('/linux/i', $u_agent)) {
    $platform = 'linux';
  }elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
    $platform = 'mac';
  }elseif (preg_match('/windows|win32/i', $u_agent)) {
    $platform = 'windows';
  }

  // Next get the name of the useragent yes seperately and for good reason
  if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){
    $bname = 'Internet Explorer';
    $ub = "MSIE";
  }elseif(preg_match('/Firefox/i',$u_agent)){
    $bname = 'Mozilla Firefox';
    $ub = "Firefox";
  }elseif(preg_match('/OPR/i',$u_agent)){
    $bname = 'Opera';
    $ub = "Opera";
  }elseif(preg_match('/Chrome/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
    $bname = 'Google Chrome';
    $ub = "Chrome";
  }elseif(preg_match('/Safari/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
    $bname = 'Apple Safari';
    $ub = "Safari";
  }elseif(preg_match('/Netscape/i',$u_agent)){
    $bname = 'Netscape';
    $ub = "Netscape";
  }elseif(preg_match('/Edge/i',$u_agent)){
    $bname = 'Edge';
    $ub = "Edge";
  }elseif(preg_match('/Trident/i',$u_agent)){
    $bname = 'Internet Explorer';
    $ub = "MSIE";
  }

  // finally get the correct version number
  $known = array('Version', $ub, 'other');
  $pattern = '#(?<browser>' . join('|', $known) .
')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
  if (!preg_match_all($pattern, $u_agent, $matches)) {
    // we have no matching number just continue
  }
  // see how many we have
  $i = count($matches['browser']);
  if ($i != 1) {
    //we will have two since we are not using 'other' argument yet
    //see if version is before or after the name
    if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
        $version= $matches['version'][0];
    }else {
        $version= $matches['version'][1];
    }
  }else {
    $version= $matches['version'][0];
  }

  // check if we have a number
  if ($version==null || $version=="") {$version="?";}

  return array(
    'userAgent' => $u_agent,
    'browser'      => $bname,
    'os' => getOS(),
    'version'   => $version,
    'platform'  => $platform,
    'ip' => getIP()
  );
} 

