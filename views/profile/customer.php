<!doctype html>
<html lang="en">

<head>
    <title>Customer Profile | MotoBase</title>
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
locked('customer');
include("views/partials/head.php"); 
?>

<body>
    <?php require('views/partials/nav.php');?>
   <div id="app">
       <div class="text-center container">
           <a href="<?php echo route('search').queryString();?>" class="btn btn-outline-secondary btn-sm mb-3"><i class="bi bi-arrow-left"></i> Back to search</a>


        <?php $user = getCustomer(); ?>
        <h4 class="mt-5">Hello <b>
                <?php echo $user['name'];?>
            </b></h4>
        Here are your bookings <br>
        <div class="mt-5 container">
            <?php 
            
            require('db.php');
            $bookings = mysqli_query($con,"SELECT * FROM `bookings` where customerID = '".$user['customerID']."' ORDER BY `bookedat` DESC");

        
            if(!mysqli_num_rows($bookings)) echo "<div class='alert alert-warning mx-5'>No Bookings Found</div>";

            
            foreach ($bookings as $booking) { 
        
                $car = getBookedCar($booking['carID']); 
                $host = getHost($car['hostID']);
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
                                <?php echo $car['seats'];?> Seater <br>
                                <small><b><?php echo $host['businessName'];?></b></small>
                                <br>
                                <span class="badge rounded-pill bg-motobase text-white">Start Date: <b><?php echo ($booking['startDate']);?></b></span> 
                                <span class="badge rounded-pill bg-secondary text-white">For <b><?php echo ($booking['numDays']);?> Days</b></span>
                            </p>
                                <span class="card-text bg-success text-white rounded-pill p-2">
                                Total: <b><?php echo strtoinr((int)$booking['numDays']*(int)$car['rent']);?></b></h5>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
       </div>
   </div>
</body>

</html>