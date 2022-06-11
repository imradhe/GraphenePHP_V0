<?php
class Car
{
    protected $carID;
    protected $hostID;
    protected $model;
    protected $carNumber;
    protected $photo;
    protected $photoName;
    protected $seats;
    protected $rent;
    protected $updated_at;
    protected $con;
    public $errors;

    
    public function __construct(){
        // Require Database
        require('db.php');

        // Database Instantiation
        $this->db = new mysqli($config['DB_HOST'],$config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE']);
        $this->error = false;

    }

    // Check if car exists
    public function check($carNumber){
        return mysqli_num_rows($this->db->query("SELECT * from cars where carNumber='$carNumber'"));
    }

    public function getFile($input){
        $file = $_FILES[$input];
        $file['ext'] = strtolower(substr($file['name'], strrpos($file['name'],".")+1));
        $file['name'] = str_replace(' ', '',getHost($this->hostID)['businessName']).time();
        return $file;
    }
    
    // Form Validations
    public function validate($hostID, $model, $carNumber, $photo,$seats, $rent){
        
        // hostID Validation
        if(empty(getHost($hostID))){
            $errors['hostID'] = true;
            $errorMsgs['hostID'] = "Host ID is invalid";
        }
        else{
            $errors['hostID'] = false;
            $errorMsgs['hostID'] = "";
        }

        //Model
        if(empty($model)){
            $errors['model'] = true;
            $errorMsgs['model'] = "Model is invalid";
        }elseif(strlen($model)<=5){            
            $errors['model'] = true;
            $errorMsgs['model'] = "Model can't be less than 6 Characters";
        }
        else{
            $errors['model'] = false;
            $errorMsgs['model'] = "";
        }

        // carNumber Validation        
        $carNumberPattern = "/^[A-Z]{2}[ -][0-9]{1,2}(?: [A-Z])?(?: [A-Z]*)? [0-9]{4}$/";

        if(empty($carNumber)){
            $errors['carNumber'] = true;
            $errorMsgs['carNumber'] = "Car Number is invalid";
        }elseif(!preg_match($carNumberPattern, $carNumber)){
            $errors['carNumber'] = true;
            $errorMsgs['carNumber'] = "Car Number is invalid";
        }elseif($this->check($carNumber)){
            $errors['carNumber'] = true;
            $errorMsgs['carNumber'] = "Car already in use";
        }else{
            $errors['carNumber'] = false;
            $errorMsgs['carNumber'] = "";
        }

        // Photo Validation
        $allowed = array('jpg', 'jpeg', 'png');
        if(!in_array($photo['ext'], $allowed)){
            $errors['photo'] = true;
            $errorMsgs['photo'] = "Only JPEG, JPG, and PNG files are allowed";
        }elseif($photo['error'] != 0){
            $errors['photo'] = true;
            $errorMsgs['photo'] = "Something went wrong";
        }else{
            if($photo['size'] < 2000000){
                $errors['photo'] = false;
                $errorMsgs['photo'] = "";
            }else{
                $errors['photo'] = true;
                $errorMsgs['photo'] = "File size can't be more than 2 MB";
            }
        }

        //seats
        if(empty($seats)){
            $errors['seats'] = true;
            $errorMsgs['seats'] = "seats is invalid";
        }elseif(!($seats == 5) && !($seats == 7)){            
            $errors['seats'] = true;
            $errorMsgs['seats'] = "seats must be 5 or 7";
        }
        else{
            $errors['seats'] = false;
            $errorMsgs['seats'] = "";
        }

        //rent
        if(empty($rent)){
            $errors['rent'] = true;
            $errorMsgs['rent'] = "rent is invalid";
        }elseif($rent< 1000){            
            $errors['rent'] = true;
            $errorMsgs['rent'] = "rent must be atleast ".strtoinr('1000');
        }
        else{
            $errors['rent'] = false;
            $errorMsgs['rent'] = "";
        }

        // Calculating error
        $error = false;
        foreach ($errors as $i) {
          $error += $i;  
        }
        return ['error'=>$error, 'errorMsgs'=>$errorMsgs, 'photo' => $photo];

    }


    // Create Car
    public function create($hostID, $model, $carNumber, $photo,$seats, $rent){

        $this->hostID = trim($hostID);
        $this->model = trim(mysqli_real_escape_string($this->db, $model));
        $this->carNumber = trim(mysqli_real_escape_string($this->db, $carNumber));
        $this->photo = $this->getFile($photo);
        $this->seats = (int)trim(mysqli_real_escape_string($this->db, $seats));
        $this->rent = (int)trim(mysqli_real_escape_string($this->db, $rent));

        $validate = $this->validate($this->hostID, $this->model, $this->carNumber, $this->photo,$this->seats, $this->rent);

        if($validate['error']) return ['error'=> $validate['error'],'errorMsgs'=>$validate['errorMsgs']];
        else{
            $this->photoName = $this->photo['name'].'.'.$this->photo['ext'];
            // New Car Creation

            $this->carID = md5($this->hostID.$this->carNumber.time());
            $createCar =  $this->db->query("INSERT INTO cars (`carID`,`hostID`,`model`,`carNumber`,`photo`,`seats`,`rent`) VALUES ('$this->carID' ,'$this->hostID' ,'$this->model' ,'$this->carNumber' ,'$this->photoName' ,'$this->seats' ,'$this->rent') ");

            if($createCar){
                    $photoUpload = move_uploaded_file($this->photo['tmp_name'], 'assets/img/cars/'.$this->photo['name'].'.'.$this->photo['ext']);

                    if($photoUpload){
                        $this->error = false;
                        $this->errorMsgs = null;
                    }else{
                        $this->error = true;
                        $this->errorMsgs['photoUpload'] = 'Photo Upload Failed';
                    }
                }else{
                    $this->error = true;
                    $this->errorMsgs['createCar'] = 'Car Creation Failed';
                }
        }

        if($this->error) return ['error'=> $this->error,'errorMsgs'=> $this->errorMsgs, 'photo' => $this->photo];
        else{
            header('location:'.route('profile'));
        }
    }

    // Edit Form Validations
    public function validateEdit($photo, $rent, $status){
        
        

        // Photo Validation
        $allowed = array('jpg', 'jpeg', 'png');
        if(!in_array($photo['ext'], $allowed)){
            $errors['photo'] = true;
            $errorMsgs['photo'] = "Only JPEG, JPG, and PNG files are allowed";
        }elseif($photo['error'] != 0){
            $errors['photo'] = true;
            $errorMsgs['photo'] = "Something went wrong";
        }else{
            if($photo['size'] < 2000000){
                $errors['photo'] = false;
                $errorMsgs['photo'] = "";
            }else{
                $errors['photo'] = true;
                $errorMsgs['photo'] = "File size can't be more than 2 MB";
            }
        }

        //rent
        if(empty($rent)){
            $errors['rent'] = true;
            $errorMsgs['rent'] = "rent is invalid";
        }elseif($rent< 1000){            
            $errors['rent'] = true;
            $errorMsgs['rent'] = "rent must be atleast ".strtoinr('1000');
        }
        else{
            $errors['rent'] = false;
            $errorMsgs['rent'] = "";
        }

        //status
        if(empty($status)){
            $errors['status'] = true;
            $errorMsgs['status'] = "status is invalid";
        }elseif(($status != 'available') && $status != 'removed'){            
            $errors['status'] = true;
            $errorMsgs['status'] = "Invalid Status";
        }
        else{
            $errors['status'] = false;
            $errorMsgs['status'] = "";
        }

        // Calculating error
        $error = false;
        foreach ($errors as $i) {
          $error += $i;  
        }
        return ['error'=>$error, 'errorMsgs'=>$errorMsgs, 'photo' => $photo];

    }

    //Edit Car
    public function edit($carID, $photo, $rent, $status){

        $this->hostID = getHostByEmail(getSession()['email'])['hostID'];
        $this->carID = trim($carID);
        $this->photo = $this->getFile($photo);
        $this->rent = (int)trim(mysqli_real_escape_string($this->db, $rent));
        $this->status = trim(mysqli_real_escape_string($this->db, $status));

        $validate = $this->validateEdit($this->photo, $this->rent, $this->status);

        if($validate['error']) return ['error'=> $validate['error'],'errorMsgs'=>$validate['errorMsgs']];
        else{
            $this->photoName = $this->photo['name'].'.'.$this->photo['ext'];
            // New Car Creation

            $editCar =  $this->db->query("UPDATE cars SET photo = '$this->photoName',rent = '$this->rent', status = '$this->status' WHERE carID = '$this->carID'");

            if($editCar){
                    $photoUpload = move_uploaded_file($this->photo['tmp_name'], 'assets/img/cars/'.$this->photo['name'].'.'.$this->photo['ext']);

                    if($photoUpload){
                        $this->error = false;
                        $this->errorMsgs = null;
                    }else{
                        $this->error = true;
                        $this->errorMsgs['photoUpload'] = 'Photo Upload Failed';
                    }
                }else{
                    $this->error = true;
                    $this->errorMsgs['editCar'] = 'Car Edit Failed';
                }
        }

        if($this->error) return ['error'=> $this->error,'errorMsgs'=> $this->errorMsgs, 'photo' => $this->photo];
        else{
            header('location:'.route('profile'));
        }
    }

}

