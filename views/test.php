<?php
$cookie_name = "auth";
$cookie_value = md5("John Doe");


print_r(getDevice());


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