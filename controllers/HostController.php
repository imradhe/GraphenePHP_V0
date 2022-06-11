<?php
class Host
{
    protected $hostID;
    protected $name;
    protected $email;
    protected $phone;
    protected $businessName;
    protected $status;
    protected $con;
    public $errors;

    
    public function __construct(){
        // Require Database
        require('db.php');

        // Database Instantiation
        $this->db = new mysqli($config['DB_HOST'],$config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE']);
        $this->error = false;

    }

    // Check if email exists
    public function check($email, $role){
        return mysqli_num_rows($this->db->query("SELECT * from users where email='$email'"));
    }
    
    // Form Validations
    public function validate($name, $email, $phone, $businessName, $password, $role){
        
        // Name Validation
        if(empty($name)){
            $errors['name'] = true;
            $errorMsgs['name'] = "Name can't be empty";
        }elseif(strlen($name)<=5){            
            $errors['name'] = true;
            $errorMsgs['name'] = "Name can't be less than 6 Characters";
        }
        else{
            $errors['name'] = false;
            $errorMsgs['name'] = "";
        }

        // Email Validation        
        $emailPattern = "/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/";
        if(empty($email)){
            $errors['email'] = true;
            $errorMsgs['email'] = "Email can't be empty";
        }elseif(!preg_match($emailPattern, $email)){
            $errors['email'] = true;
            $errorMsgs['email'] = "Email is invalid";
        }elseif($this->check($email, $role)){
            $errors['email'] = true;
            $errorMsgs['email'] = "Email already in use";
        }else{
            $errors['email'] = false;
            $errorMsgs['email'] = "";
        }

        
        $phonePattern = "/^([6-9][0-9]{9})$/";

        if(empty($phone)){
          $errors['phone'] = true;
          $errorMsgs['phone'] = "Phone can't be empty";
        }
        elseif(preg_match($phonePattern, $phone)){
          $errors['phone'] = false;   
        }
        else{                   
          $errors['phone'] = true;
          $errorMsgs['phone'] = "Invalid Phone";       
        }


        // Business Name Validation
        if(empty($businessName)){
            $errors['businessName'] = true;
            $errorMsgs['businessName'] = "Business Name can't be empty";
        }elseif(strlen($businessName)<=5){            
            $errors['businessName'] = true;
            $errorMsgs['businessName'] = "Business Name can't be less than 6 Characters";
        }
        else{
            $errors['businessName'] = false;
            $errorMsgs['businessName'] = "";
        }

        // Password Validation
        if(empty($password)){
            $errors['password'] = true;
            $errorMsgs['password'] = "Password can't be empty";
        }
        elseif(strlen($password)<=5){            
            $errors['password'] = true;
            $errorMsgs['password'] = "Can't be less than 6 Characters";
        }
        elseif(!preg_match('@\W|_@', $password)){            
            $errors['password'] = true;
            $errorMsgs['password'] = "Must Contain atleast one special character";
        }
        elseif(!preg_match('@[0-9]@', $password)){            
            $errors['password'] = true;
            $errorMsgs['password'] = "Must Contain atleast one number";
        }
        elseif(!preg_match('@[a-z]@', $password)){            
            $errors['password'] = true;
            $errorMsgs['password'] = "Must Contain atleast one lowercase";
        }
        elseif(!preg_match('@[A-Z]@', $password)){            
            $errors['password'] = true;
            $errorMsgs['password'] = "Must Contain atleast one lowercase";
        }
        else{
            $errors['password'] = false;
            $errorMsgs['password'] = "";
        }

        // Calculating error
        $error = false;
        foreach ($errors as $i) {
          $error += $i;  
        }
        return ['error'=>$error, 'errorMsgs'=>$errorMsgs];

    }


    public function register($name, $email, $phone, $businessName, $password, $role){

        $this->name = trim(mysqli_real_escape_string($this->db, $name));
        $this->email = strtolower(trim(mysqli_real_escape_string($this->db, $email)));
        $this->phone = (trim(mysqli_real_escape_string($this->db, $phone)));
        $this->businessName = (trim(mysqli_real_escape_string($this->db, $businessName)));
        $this->password = md5( mysqli_real_escape_string($this->db, $password));
        $this->passwordWithoutMD5 =  mysqli_real_escape_string($this->db, $password);
        $this->role = strtolower(trim(mysqli_real_escape_string($this->db, $role)));

        $validate = $this->validate($this->name,$this->email,$this->phone,$this->businessName,$this->passwordWithoutMD5, $this->role);

        if($validate['error']) return ['error'=> $validate['error'],'errorMsgs'=>$validate['errorMsgs']];
        else{

            // User Account Creation
            $createUser =  $this->db->query("INSERT INTO users (`name`,`email`, `password`,`role`) VALUES ('$this->name' ,'$this->email' ,'$this->password' ,'$this->role') ");

            if($createUser){

                if($this->role == 'host'){

                    // Generating host ID
                    $hostID = md5($this->email.$this->password.uniqid());

                    // host account creation
                    $createHost = $this->db->query("INSERT INTO hosts (`hostID`, `name`,`email`,`phone`,`businessName`) VALUES ('$hostID', '$this->name' ,'$this->email','$this->phone','$this->businessName' ) ");

                    if($createHost){
                        $this->errorMsgs = null;
                        $this->error = false;
                    }else{
                        $this->errorMsgs['createHost'] = 'host account creation failed';
                        $this->error = true;
                    }

                }
            }else{
                $this->errorMsgs['createUser'] = 'User account creation failed';
            }
        }

        if($this->error) return ['error'=> $this->error,'errorMsgs'=> $this->errorMsgs];
        else{
            controller('Auth');
            $auth = new Auth();
            $auth->login($this->email, $this->passwordWithoutMD5);
        }
    }


}

