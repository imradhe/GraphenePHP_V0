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

/*
Users Table:

Name
Email
username (PK)
role
status
password

CREATE TABLE users (
    username varchar(30) NOT NULL,
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    role ENUM ('user','moderator','admin') DEFAULT 'user',
    status int DEFAULT 0,
    PRIMARY KEY (username)
);


logins table
login ID = md5(username.time)
username (FK)
last login
browser type
ip address


CREATE TABLE logs (
    username varchar(30) NOT NULL,
    loginID varchar(32) NOT NULL,
    last TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    browser varchar(32) NOT NULL,
    FOREIGN KEY (username) REFERENCES users(username)
);