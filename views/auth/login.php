<?php
    if(isset($_POST['btn-login'])){
        require("views/auth/AuthController.php");
        $auth = new Auth();
        $user = $auth->login($_POST['email'],$_POST['password']);
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content=""> 
    <link href="../../assets/img/KEl.svg" rel="icon">
    <link href="../../assets/img/KEl.svg" rel="apple-touch-icon">
    <title>Login | Kautilya Education</title>
<!-- CSS only -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<!-- JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
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
  <body class="text-center">
    <form method="POST" name="Login" class="form-signin">
  <h1 class="h3 mb-3 font-weight-normal">Log In </h1>
  <div class="mb-3">
    <input name="email" type="email" id="email" class="form-control" placeholder="Email" required>
    <strong id="emailMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
  </div>

  <div class="mb-3">      
  <input type="password" name="password" id="password" class="form-control" placeholder="Password" required autofocus>
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