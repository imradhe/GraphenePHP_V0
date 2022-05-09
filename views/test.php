<?php
$username = "arun";
$password = "Arun@123";


/** 
 *
 * if("arun" == $username && md5("Arun@123") == md5($password)){
    $time = new DateTime();
    $time = $time->format('Y-m-d H:i:s');
    echo $time."<br>";
    $auth = md5($username.md5($password).time());
    setcookie("auth", $auth, time() + (86400 * 30), "/");
}else echo "Invalid Login <br>";
*/
print_r($_COOKIE);

if($_COOKIE['auth'] == md5($username.md5($password).time())) echo "Loggedin";
else echo "Invalid Session";

