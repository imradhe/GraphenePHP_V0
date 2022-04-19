<?php 
require('./db.php');
$participants = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM `students`"));
echo json_encode($participants);
