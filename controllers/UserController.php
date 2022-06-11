<?php 
class User
{
    protected $name;
    protected $email;
    protected $password;
    protected $passwordWithoutMD5;
    protected $role;
    protected $status;
    protected $db;
    public $error;
    public $errorMsgs;
    
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
    public function validate($name, $email, $phone, $password, $role){
        
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
          $errorMsgs['phone'] = "";
        }
        else{                   
          $errors['phone'] = true;
          $errorMsgs['phone'] = "Invalid Phone";       
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
        return ['error'=>$error, 'errorMsgs'=>$errorMsgs, 'phone' => $phone];

    }


    public function register($name, $email, $phone, $password, $role){

        $this->name = trim(mysqli_real_escape_string($this->db, $name));
        $this->email = strtolower(trim(mysqli_real_escape_string($this->db, $email)));

        $this->phone = trim(mysqli_real_escape_string($this->db, $phone));
        
        $this->password = md5( mysqli_real_escape_string($this->db, $password));
        $this->passwordWithoutMD5 =  mysqli_real_escape_string($this->db, $password);
        $this->role = strtolower(trim(mysqli_real_escape_string($this->db, $role)));

        $validate = $this->validate($this->name,$this->email,$this->phone,$this->passwordWithoutMD5, $this->role);

        if($validate['error']) return ['error'=> $validate['error'],'errorMsgs'=>$validate['errorMsgs']];
        else{

            // User Account Creation
            $createUser =  $this->db->query("INSERT INTO users (`name`,`email`,`password`,`role`) VALUES ('$this->name' ,'$this->email' ,'$this->password' ,'$this->role') ");

            if($createUser){

                if($this->role == 'customer'){

                    // Generating Customer ID
                    $customerID = md5($this->email.$this->password.uniqid());

                    // Customer account creation
                    $createCustomer = $this->db->query("INSERT INTO customers (`customerID`, `name`,`email`, `phone`) VALUES ('$customerID', '$this->name' ,'$this->email' ,'$this->phone') ");

                    if($createCustomer){
                        $this->errorMsgs = null;
                        $this->error = false;
                    }else{
                        $this->errorMsgs['createCustomer'] = 'Customer account creation failed';
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