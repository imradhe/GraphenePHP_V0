<!doctype html>
<html lang="en">

<head>
    <title>Host Bookings | MotoBase</title>
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }
    </style>
</head>

<?php
locked('host');
include("views/partials/head.php"); 
?>

<body>
    <?php require('views/partials/nav.php');?>
   <div id="app">
       <div class="text-center container">
         
       
       
       <?php $host = getHostByEmail(getUser()['email']); ?>
        <h4 class="mt-5">Hello <b>
                <?php echo $host['name'];?>
            </b></h4>
            <a href='<?php echo route('profile');?>' class="btn btn-outline-motobase btn-sm">
            <i class="bi bi-person-circle"></i> Go to Profile
        </a><br>
        Here are your bookings <br>
        <div class="mt-5 container">
            
            <?php 
            require('db.php');
            $bookings = mysqli_query($con,"SELECT * FROM `bookings` where hostID = '".$host['hostID']."' ORDER BY `bookedat` DESC");

        
            if(!mysqli_num_rows($bookings)) echo "<div class='alert alert-warning mx-5'>No Bookings Found</div>";

            
            foreach ($bookings as $booking) { 
        
                $car = getBookedCar($booking['carID']); 
                if(empty($car)){
            ?>
        
            <div class="card mb-3">
                <div class="row gx-3">
                    <div class="col-sm-3 text-center">
                        <img src="<?php echo assets('img/cars/'.$car['photo']);?>" class="img-fluid rounded-start m-3"
                            style="max-height:160px;" alt="...">
                    </div>
                    <div class="col-sm-9">
                        <div class="card-body text-start">
                            <h5 class="card-title fw-bolder user-select-none">
                                <?php echo $car['model'];?>
                            </h5>
                            <p class="card-text user-select-none">
                                <?php echo $car['carNumber'];?> •
                                <?php echo $car['seats'];?> Seater 
                                <br>
                                <p><?php echo getCustomerByID($booking['customerID'])['name'];?>  (<a href="tel:+91<?php echo getCustomerByID($booking['customerID'])['phone'];?>">+91 <?php echo getCustomerByID($booking['customerID'])['phone'];?></a>)</p><br>
                                <span class="badge rounded-pill bg-motobase text-white">Start Date: <b><?php echo ($booking['startDate']);?></b></span> 
                                <span class="badge rounded-pill bg-secondary text-white">For <b><?php echo ($booking['numDays']);?> Days</b></span>
                                </span>
                                <span class="badge bg-success text-white rounded-pill">
                                Total: <b><?php echo strtoinr((int)$booking['numDays']*(int)$car['rent']);?></b></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php }else{echo "<div class='alert alert-warning mx-5'>No other cars Found</div>";} }?>

        </div>
       </div>
   </div>
</body>

</html>