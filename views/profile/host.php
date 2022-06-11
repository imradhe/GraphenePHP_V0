
<!doctype html>
<html lang="en">

<head>
    <title>Host Profile | MotoBase</title>
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
        Here are your cars <br>
        <div class="mt-5 container">
        <a href='<?php echo route('cars/new');?>' class="btn btn-outline-motobase btn-sm">
            <i class="bi bi-plus-circle-fill"></i> Add Car
        </a>
        <a href='<?php echo route('host/bookings');?>' class="btn btn-outline-motobase btn-sm">
            <i class="bi bi-calendar3"></i> My Bookings
        </a>

            <?php 
            require('db.php');
            $cars = mysqli_query($con,"SELECT * FROM `cars` where hostID = '".$host['hostID']."'");

             
        
            if(!mysqli_num_rows($cars)) echo "<div class='alert alert-warning mx-5'>No cars Found</div>";

            
            foreach ($cars as $car) { 
        
                $car = getCar($car['carID']); 
                if(!empty($car)){
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
                            </p>
                                
                            <h5 class="card-text fw-bolder user-select-none">
                                <?php echo strtoinr($car['rent']);?>/day
                            </h5>
                            <a href="<?php echo route('cars/edit').'?carID='.$car['carID']?>" class="stretched-link text-decoration-none"><i class="bi bi-pencil-square"></i> Edit</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php }else echo "<div class='alert alert-warning mx-5'>No other cars Found</div>"; }?>
        </div>
       </div>
   </div>
</body>

</html>