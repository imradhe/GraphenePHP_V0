<?php
//locked();
if(!isset($_GET['search'])){
    $startDate = (empty($_GET['startDate']))? date("Y-m-d") : $_GET['startDate'];
    $numDays = (empty($_GET['numDays']))? '1' : $_GET['numDays'];
    $seats = (empty($_GET['seats']))? '' : $_GET['seats'];
    header("Location:".route('search')."?city=Chennai&startDate=".$startDate."&numDays=".$numDays."&seats=".$seats."&search=");
}


?>
<?php include("views/partials/head.php") ?>
<body>

    <?php require('views/partials/nav.php');?>

  <div id="app" class="container">





    <div class="row gx-5">
        <form method="get" id="sidebar" class="col-lg-3 col-md-4 sidebar d-none d-lg-block">
            <div class="">
                <div class="p-3 border">
        
                    <div class="form-group mb-3">
                        <h5 class="fw-bold mt-4">City</h5>
                        <div class="input-group mb-3">
                            <input type="city" class="form-control" placeholder="City" value="Chennai" name="city" readonly>
                            <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                        </div>
                    </div>
        
                    <?php if(getSession()){ ?>
                    
                    <div class="form-group mb-3">                    
                        <h5 class="fw-bold mt-4">Start Date</h5>
                        <div class="input-group mb-3">
                            <input type="date" class="form-control" value="<?php echo (empty($_GET['startDate']))? date("Y-m-d") : $_GET['startDate'] ;?>" name="startDate">
                        </div>
                    </div>
        
        
                        <div class="form-group mb-3">                    
                            <h5 class="fw-bold mt-4">Number of Days</h5>
                            <div class="input-group mb-3">
                                <select id="numDays" class="form-select form-select mb-3" name="numDays">
                                    <option value="1"  <?php echo ($_GET['numDays'] == "1") ?"selected" : "";?>>1 Day</option>
                                    <?php for ($i=2; $i < 7; $i++) { ?>
                                    <option value="<?php echo $i;?>" <?php echo ($_GET['numDays'] == $i) ?"selected" : "";?>><?php echo $i;?> Days</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    <?php }?>
        
                    <div class="form-group mb-3">                    
                        <h5 class="fw-bold mt-4">Seats</h5>
                        <div class="input-group mb-3">
        
        
                            
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="seats" id="seats-all" value="all" <?php echo (($_GET['seats'] != '5') || ($_GET['seats'] != '7')) ? 'checked': '';?>>
                                <label class="btn btn-outline-secondary" for="seats-all">All</label>
                            
                                <input type="radio" class="btn-check" name="seats" id="seats-5" value="5" <?php echo ($_GET['seats'] == '5') ? 'checked': '';?>>
                                <label class="btn btn-outline-secondary" for="seats-5">5</label>
                            
                                <input type="radio" class="btn-check" name="seats" id="seats-7" value="7" <?php echo ($_GET['seats'] == '7') ? 'checked': '';?>>
                                <label class="btn btn-outline-secondary" for="seats-7" >7</label>
                            </div>
                        </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-motobase" name="search">Find Cars</button>
                            </div>
        
                    </div>
                    
                </div>
            </div>
        </form>

        
        <div class="col-lg-8">
            
        <center>

        <button class="btn btn-outline-motobase d-lg-none btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#filter" aria-controls="filter">
        <i class="bi bi-funnel"></i> Filters
        </button>

        </center>
            <div class="pb-3 px-0">
                <?php
                    require('db.php');
                    $seats = $_GET['seats'];
                    $whereClause = ($seats == 5 || $seats == 7)? "where  seats = '$seats' and status = 'available'" : "where status = 'available'";
                    $cars = mysqli_query($con,"SELECT * FROM `cars` ".$whereClause);

                        
                    if(!mysqli_num_rows($cars)) echo "<div class='alert alert-warning mx-5 text-center'>No cars Found</div>";
            
                    foreach ($cars as $car) { 

                        $carID = $car['hostID'];
                    $host = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from hosts where hostID='$carID'"));
                        ?>
                        
                        <div class="card mb-3">
                            <div class="row gx-3">
                                <div class="col-sm-3 col-4 text-center">
                                    <img src="<?php echo assets('img/cars/'.$car['photo']);?>" class="img-fluid rounded-start m-3" style="max-height:160px;" alt="<?php echo $car['model'];?>">
                                </div>
                                <div class="col-sm-6 col-8">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bolder user-select-none"><?php echo $car['model'];?></h5>
                                        <p class="card-text user-select-none"><?php echo $car['carNumber'];?> • <?php echo $car['seats'];?> Seater</p>
                                        <p class="card-text mt-5 pt-3 h5 user-select-none"><small class="text-muted"> <?php echo ($host['status'] != 'unverified')? '<i class="bi bi-patch-check-fill text-motobase"></i>' : ''; ?>  <?php echo $host['businessName'];?></small></p>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-12 text-center py-3">
                                    <h4 class="card-text user-select-none"><?php echo strtoinr($car['rent']);?>/day</p>
                                    <a href="<?php echo route('rent').'?carID='.$car['carID'].'&startDate='.$_GET['startDate'].'&numDays='.$_GET['numDays']; ?>" class="btn btn-sm btn-motobase stretched-link">Rent Now</a>
                                </div>
                            </div>
                        </div>
                        <?php }


                ?>
            </div>
        </div>
    </div>
</div>



<div class="offcanvas offcanvas-start" tabindex="-1" id="filter" aria-labelledby="filterLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="filterLabel">Filter</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <form method="get">

    </form>      
  </div>
</div>

  <script>
    var filter = document.querySelector('#filter .offcanvas-body form')
    var sidebar = document.querySelector('.sidebar')
    var filterForm = sidebar.outerHTML
                        
    addFilterForm()


    window.addEventListener('load', function(){
        addFilterForm()
    })
    window.addEventListener('resize', function(){
        addFilterForm()
    })

    function addFilterForm(){
        if(window.outerWidth <= 991){
            filter.innerHTML = filterForm
            sidebar.outerHTML = ''
        }else{
            sidebar.outerHTML = filterForm
            filter.innerHTML = ''
        }
    }
</script>

</body>

</html>