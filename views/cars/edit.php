<?php
    locked('host');
    $hostID = getHostByEmail(getSession()['email'])['hostID'];
    $getCar = getCar($_GET['carID']);
    if($hostID != $getCar['hostID']) header('Location:'.route('profile'));
    if(isset($_POST['btn-edit'])){
        error_reporting(1);
        controller("Car");
        $car = new Car();
        $editCar = $car->edit($_GET['carID'], 'photo', $_POST['rent'], $_POST['status']);
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Edit Car | MotoBase</title>
    <style>
      html,
body {
  height: 100%;
}

body {
  padding-bottom: 40px;
  background-color: #f5f5f5;
}

.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin-top: 2vh !important;
  margin: auto;
}
.form-signin .checkbox {
  font-weight: 400;
}
.form-signin .form-control {
  position: relative;
  box-sizing: border-box;
  height: auto;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
#eye{
  cursor: pointer;
}
</style>
  </head>
  
  <?php include("views/partials/head.php"); ?>
  
  <body class="text-center">
    <?php require('views/partials/nav.php');?>
  <div class="logo mt-5 pt-5">
    <a href="<?php echo home()?>"><img src="<?php echo home().$config['APP_LOGO'];?>" alt="MotoBase" class="img-fluid"></a>
  </div>

  <form method="POST" name="Register" class="form-signin" enctype="multipart/form-data">
  <h2 class="mb-3 fw-bolder">Edit Car</h1>
  <?php
  $car = getCar($_GET['carID']); 
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
                        </div>
                    </div>
                </div>
            </div>
            <?php }else echo "<div class='alert alert-warning mx-5'>No other cars Found</div>"; 
            ?>

    <?php if(!empty($editCar['errorMsgs'])){ ?>
        <div class="alert alert-danger" role="alert">
          <?php foreach($editCar['errorMsgs'] as $errorMsg){
              echo (empty($errorMsg)) ? '' : $errorMsg."<br>";
          }  ?>
        </div>
      <?php }?>
  
  
  <div class="mb-3">
    <select id="status" class="form-select form-select mb-3" name="status">
        <option value="available"  <?php echo ($_POST['status'] == "available") ?"selected" : "";?>>Available</option>
        <option value="removed"  <?php echo ($_POST['status'] == "removed") ?"selected" : "";?>>Removed</option>
    </select>
    <strong id="statusMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
  </div>

  
  <div class="mb-3">
    <input name="rent" type="number" id="rent" class="form-control" placeholder="Car Rent Per Day" value="<?php echo (!empty($_POST['rent'])) ? $_POST['rent'] : '' ;?>" required>
    <strong id="rentMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
  </div>

  
  <div class="mb-3">
    <label for="photo">Car Photo</label>
    <input type="file" name="photo" id="photo" class="form-control">
    <strong id="photoMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
  </div>

  <button class="btn btn-lg btn-motobase btn-block" id="btn-edit" name="btn-edit" type="edit">Update</button>

</form>


<script>
    
      let photoError = true;
      let rentError = true;

      let photo = document.querySelector("#photo");
      let rent = document.querySelector("#rent");

      
      

      checkErrors();

      
      function validatemodel() {
        let modelValue = model.value.trim()
        let modelMsg = document.querySelector("#modelMsg")
        if (modelValue == "") {
          modelError = true
          checkErrors()
          modelMsg.innerText = "Model Name can't be empty"
          model.classList.add("is-invalid")
        }else if(modelValue.length <= 5){
          modelError = true
          checkErrors()
          modelMsg.innerText = "Model Name can't be less than 6 Characters"
          model.classList.add("is-invalid")
        }else {
          modelError = false
          checkErrors()
          model.classList.remove("is-invalid")
          model.classList.add("is-valid")
          modelMsg.innerText = ""
        }
      }

      model.addEventListener("focusout", function () {
        validatemodel()
      })
      model.addEventListener("keyup", function () {
        validatemodel()
      })




      function validatephoto() {
        let photoValue = photo.value
        let photoMsg = document.querySelector("#photoMsg")
        if (photoValue == "") {
          photoError = true
          checkErrors()
          photoMsg.innerText = "photo can't be empty"
          photo.classList.add("is-invalid")
        }else {
          photoError = false
          checkErrors()
          photo.classList.remove("is-invalid")
          photo.classList.add("is-valid")
          photoMsg.innerText = ""
        }
      }

      photo.addEventListener("focusout", function () {
        validatephoto()
      })
      photo.addEventListener("keyup", function () {
        validatephoto()
      })


      
      function validaterent() {
        let rentValue = rent.value
        let rentMsg = document.querySelector("#rentMsg")
        if (rentValue == "") {
          rentError = true
          checkErrors()
          rentMsg.innerText = "Rent can't be empty"
          rent.classList.add("is-invalid")
        }else {
          rentError = false
          checkErrors()
          rent.classList.remove("is-invalid")
          rent.classList.add("is-valid")
          rentMsg.innerText = ""
        }
      }

      rent.addEventListener("focusout", function () {
        validaterent()
      })
      rent.addEventListener("keyup", function () {
        validaterent()
      })

      function checkErrors() {
        errors = modelError + carNumberError + photoError + rentError
        if (errors) {
          document.querySelector("#btn-edit").disabled = true;
        } else {
          document.querySelector("#btn-edit").disabled = false;
        }
      }


      <?php if($editCar['error']) {?>
        validatephoto()
        validaterent()
      <?php }?>

</script>
</body>
</html>