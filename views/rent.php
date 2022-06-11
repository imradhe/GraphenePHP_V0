<?php 
            
            $request = $_GET;

            $car = getCar($request['carID']);
            $host = getHost($car['hostID']);

            if(empty(getCar($request['carID']))) header('Location:'.route('search').queryString());
            
            if(isset($_POST['book'])){
                $request = $_POST;
                controller("Booking");
                $booking = new Booking();
                $booking->book($car['carID'], getCustomer()['customerID'], $request['startDate'], $request['numDays']);                
            }
            ?>
<!doctype html>
<html lang="en">

<head>
    <title>Rent | MotoBase</title>
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
        
        <div class="container">

            <a href="<?php echo route('search').queryString();?>" class="btn btn-outline-secondary btn-sm mb-3"><i class="bi bi-arrow-left"></i> Back to search</a>
            <form method="post" id="rent" class="p-3 border text-center">
                
            <div class="container">
                    <img src="<?php echo assets('img/cars/'.$car['photo']);?>" class="img-fluid rounded-start m-3" style="max-height:160px;" alt="<?php echo $car['model'];?>">

                        <h4><b><?php echo $car['model']; ?></b></h4>
                        by  <b><?php echo $host['businessName']; ?></b>

                        <div class="row my-3">
                            <div class="input-group mb-3 col-md">
                                <input type="city" class="form-control" placeholder="City" value="Chennai" name="city" id="city"
                                    readonly>
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                            </div>
                            <div class="input-group mb-3 col-md">
                                <input type="date" class="form-control"
                                    value="<?php echo (empty($request['startDate']))? date(" Y-m-d") : $request['startDate']
                                    ;?>" name="startDate">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="mb-3 col-md">
                                <select id="numDays" class="form-select form-select mb-3" name="numDays">
                                    <option value="1" <?php echo ($request['numDays']=="1" ) ?"selected" : "" ;?>>1 Day
                                    </option>
                                    <?php for ($i=2; $i < 7; $i++) { ?>
                                    <option value="<?php echo $i;?>" <?php echo ($request['numDays']==$i) ?"selected" : ""
                                        ;?>>
                                        <?php echo $i;?> Days
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3 col-md">
                                <input type="carNumber" class="form-control" placeholder="Car Number" name="carNumber" value="<?php echo $car['carNumber']; ?>" readonly>
                                
                            </div>
                        </div>


                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-motobase" name="book">Book</button>
                            </div>
                </div>


                
            </form>
        </div>
    </div>
</body>

</html>