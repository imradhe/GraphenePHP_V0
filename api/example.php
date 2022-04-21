<?php
header('Content-Type: application/json');        
require('./db.php');

$data = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM `students`"));

if(!empty($data)){
    $res['status'] = '200';
    $res['message'] = 'Success';
    $res['data'] = $data;
}else{
    $res['status'] = '500';
    $res['message'] = mysqli_error($con);
    $res['data'] = $data;
}

http_response_code($res['status']);
echo json_encode($res);