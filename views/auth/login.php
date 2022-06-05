<?php
      require("views/auth/AuthController.php");
      $auth = new Auth();
    if(isset($_POST['btn-login'])){
      $user = $auth->login($_POST['email'],$_POST['password']);
    }else{
      if(getSession()) header("Location:".home());
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Login | Graphene PHP</title>
    <style>
      html,
body {
  height: 100%;
}

body {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #f5f5f5;
}

.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
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
    </style>
  </head>
  
  <?php include("views/partials/head.php"); ?>
  <body class="text-center">
    <form method="POST" name="Login" class="form-signin">
  <h1 class="h3 mb-3 font-weight-normal">Log In </h1>
  <?php if($_GET['loggedout']){ ?>
    <div class="alert alert-success" role="alert">
      <?php echo "Logged Out Successfully";?>
    </div>
  <?php }?>
  <?php if(!empty($auth->errors)){ ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $auth->errors;?>
    </div>
  <?php }?>
  <div class="mb-3">
    <input name="email" type="email" id="email" class="form-control" placeholder="Email" required autofocus>
    <strong id="emailMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
  </div>

  <div class="mb-3">      
  <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
  <strong id="passwordMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
  </div>

  <button class="btn btn-lg btn-primary btn-block" id="btn-login" name="btn-login" type="login">Sign in</button>
</form>

<script>
    
      let emailError = true;
      let passwordError = true;

      let email = document.querySelector("#email");
      let password = document.querySelector("#password");
      checkErrors();

      
      function checkEmailPattern(email) {
        const re =
          /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
      }

      function validateEmail() {
        let emailValue = email.value.trim()
        let emailMsg = document.querySelector("#emailMsg")
        if (emailValue == "") {
          emailError = true
          checkErrors()
          emailMsg.innerText = "Email can't be empty"
          email.classList.add("is-invalid")
        } else if (!checkEmailPattern(emailValue)) {
          emailError = true
          checkErrors()
          emailMsg.innerText = "Email is invalid"
          email.classList.add("is-invalid")
        }
        else {
          emailError = false
          checkErrors()
          email.classList.remove("is-invalid")
          email.classList.add("is-valid")
          emailMsg.innerText = ""
        }
      }

      email.addEventListener("focusout", function () {
        validateEmail()
      })
      email.addEventListener("keyup", function () {
        validateEmail()
      })


      function validatePassword() {
        let passwordValue = password.value
        let passwordMsg = document.querySelector("#passwordMsg")
        if (passwordValue == "") {
          passwordError = true
          checkErrors()
          passwordMsg.innerText = "Password can't be empty"
          password.classList.add("is-invalid")
        } 
        else {
          passwordError = false
          checkErrors()
          password.classList.remove("is-invalid")
          password.classList.add("is-valid")
          passwordMsg.innerText = ""
        }
      }

      password.addEventListener("focusout", function () {
        validatePassword()
      })
      password.addEventListener("keyup", function () {
        validatePassword()
      })


      function checkErrors() {
        errors = emailError +passwordError
        if (errors) {
          document.querySelector("#btn-login").disabled = true;
        } else {
          document.querySelector("#btn-login").disabled = false;
        }
      }

</script>
</body>
</html>