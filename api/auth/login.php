<?php
$email = $_POST['email'];
$password = $_POST['password'];

APIController('Auth');
$auth = new Auth();

echo $auth->login($email, $password);