<?php
locked();
$userRole = getUser()['role'];

if($userRole == 'customer') header('Location:'.route('profile/customer'));
elseif($userRole == 'host') header('Location:'.route('profile/host'));