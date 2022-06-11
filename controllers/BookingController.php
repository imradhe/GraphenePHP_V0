<?php 
class Booking
{
    protected $bookingID;
    protected $carID;
    protected $customerID;
    protected $hostID;
    protected $startDate;
    protected $numDays;
    protected $basePrice;
    protected $totalPrice;
    public $error;
    public $errorMsgs;
    
    public function __construct(){
        // Require Database
        require('db.php');

        // Database Instantiation
        $this->db = new mysqli($config['DB_HOST'],$config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE']);
        $this->error = false;

    }

    
    // Form Validations
    public function validate($carID, $startDate, $numDays){
        
        // carID Validation        
        if(empty($carID)){
            $errors['carID'] = true;
            $errorMsgs['carID'] = "Car not found";
        }elseif(empty(getCar($carID))){
            $errors['carID'] = true;
            $errorMsgs['carID'] = "Car not found";
        }else{
            $errors['carID'] = false;
            $errorMsgs['carID'] = "";
        }

        // Date Validation
        $today = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime(str_replace('-','/',$startDate)));
        if(empty($startDate)){
            $errors['startDate'] = true;
            $errorMsgs['startDate'] = "Date Can't be empty";
        }elseif($startDate < $today){
            $errors['startDate'] = true;
            $errorMsgs['startDate'] = "Invalid Date";
        }else{
            $errors['startDate'] = false;
            $errorMsgs['startDate'] = "";
        }

        // numDays Validation
        if(empty($numDays)){
            $errors['numDays'] = true;
            $errorMsgs['numDays'] = "Number of Days can't be empty";
        }elseif((int)$numDays > 6 ){
            $errors['numDays'] = true;
            $errorMsgs['numDays'] = "Number of Days can't be more than 6";
        }elseif((int)$numDays < 1 ){
            $errors['numDays'] = true;
            $errorMsgs['numDays'] = "Number of Days are invalid";
        }else{
            $errors['numDays'] = false;
            $errorMsgs['numDays'] = "";
        }
        // Calculating error
        $error = false;
        foreach ($errors as $i) {
          $error += $i;  
        }
        return ['error'=>$error, 'errorMsgs'=>$errorMsgs];

    }


    public function book($carID, $customerID, $startDate, $numDays){

        $this->carID = trim(mysqli_real_escape_string($this->db, $carID));
        $this->customerID = trim(getCustomer()['customerID']);
        $this->hostID = trim(getCar($this->carID)['hostID']);
        $this->startDate = trim(mysqli_real_escape_string($this->db, $startDate));
        $this->numDays = (int)trim(mysqli_real_escape_string($this->db, $numDays));
        $this->basePrice = (int)getCar($this->carID)['rent'];
        $this->totalPrice = $this->numDays * $this->basePrice;

        $validate = $this->validate($this->carID, $this->startDate, $this->numDays);

        if($validate['error']) return ['error'=> $validate['error'],'errorMsgs'=>$validate['errorMsgs']];
        else{


            // Booking Creation
            $this->bookingID = md5($this->carID.$this->customerID.time());
            $createBooking =  $this->db->query("INSERT INTO bookings (`bookingID`,`carID`,`customerID`,`hostID`,`startDate`,`numDays`,`totalPrice`) VALUES ('$this->bookingID', '$this->carID', '$this->customerID', '$this->hostID', '$this->startDate', '$this->numDays', '$this->totalPrice')");

            if($createBooking){
                $editCar =  $this->db->query("UPDATE cars SET status = 'booked' WHERE carID = '$this->carID'");
                if($editCar){
                    $this->error = false;
                    $this->errorMsgs = null;
                }else{
                    $this->error = true;
                    $this->errorMsgs['editCar'] = 'Car not booked at backend';
                }
            }else{
                $this->errorMsgs['createBooking'] = 'Booking failed';
            }
        }

        if($this->error) return ['error'=> $this->error,'errorMsgs'=> $this->errorMsgs];
        else{
            return header('Location:'.route('profile'));
        }
    }


}