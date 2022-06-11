<?php

    locked('host');
    if(isset($_POST['btn-new'])){
        error_reporting(1);
        controller("Car");
        $car = new Car();
        $hostID = getHostByEmail(getSession()['email'])['hostID'];
        $createCar = $car->create($hostID, $_POST['model'], $_POST['carNumber'], 'photo', $_POST['seats'], $_POST['rent']);
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Add Car | MotoBase</title>
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
  <h2 class="mb-3 fw-bolder">Add Car</h1>

    <?php if(!empty($createCar['errorMsgs'])){ ?>
        <div class="alert alert-danger" role="alert">
          <?php foreach($createCar['errorMsgs'] as $errorMsg){
              echo (empty($errorMsg)) ? '' : $errorMsg."<br>";
          }  ?>
        </div>
      <?php }?>
  <div class="mb-3">
    <input name="model" type="text" id="model" class="form-control" placeholder="Car Model" value="<?php echo (!empty($_POST['model'])) ? $_POST['model'] : '' ;?>" required>
    <strong id="modelMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
  </div>
  
  <div class="mb-3">
    <input name="carNumber" type="text" id="carNumber" class="form-control" placeholder="Car Number" value="<?php echo (!empty($_POST['carNumber'])) ? $_POST['carNumber'] : '' ;?>" required>
    <strong id="carNumberMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
  </div>
  
  <div class="mb-3">
    <select id="seats" class="form-select form-select mb-3" name="seats">
        <option value="5"  <?php echo ($_POST['seats'] == "5") ?"selected" : "";?>>5 Seater</option>
        <option value="7"  <?php echo ($_POST['seats'] == "7") ?"selected" : "";?>>7 Seater</option>
    </select>
    <strong id="seatsMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
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

  <button class="btn btn-lg btn-motobase btn-block" id="btn-new" name="btn-new" type="register">Register</button>

</form>


<script>
    
      let modelError = true;
      let carNumberError = true;
      let photoError = true;
      let rentError = true;

      let model = document.querySelector("#model");
      let carNumber = document.querySelector("#carNumber");
      let photo = document.querySelector("#photo");
      let seats = document.querySelector("#seats");
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


      function checkCarNumberPattern(carNumber) {
        const re = /^[A-Z]{2}[ -][0-9]{1,2}(?: [A-Z])?(?: [A-Z]*)? [0-9]{4}$/;
        return re.test(carNumber);
      }


      function validatecarNumber() {
        let carNumberValue = carNumber.value
        let carNumberMsg = document.querySelector("#carNumberMsg")
        if (carNumberValue == "") {
          carNumberError = true
          checkErrors()
          carNumberMsg.innerText = "Car Number can't be empty"
          carNumber.classList.add("is-invalid")
        }else if(!checkCarNumberPattern(carNumberValue)){
          carNumberError = true
          checkErrors()
          carNumberMsg.innerText = "Invalid Car Number"
          carNumber.classList.add("is-invalid")
        }else {
          carNumberError = false
          checkErrors()
          carNumber.classList.remove("is-invalid")
          carNumber.classList.add("is-valid")
          carNumberMsg.innerText = ""
        }
      }

      carNumber.addEventListener("focusout", function () {
        validatecarNumber()
      })
      carNumber.addEventListener("keyup", function () {
        validatecarNumber()
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
          document.querySelector("#btn-new").disabled = true;
        } else {
          document.querySelector("#btn-new").disabled = false;
        }
      }


      <?php if($createCar['error']) {?>
        validatemodel()
        validatecarNumber()
        validatephoto()
        validaterent()
      <?php }?>

</script>
</body>
</html>