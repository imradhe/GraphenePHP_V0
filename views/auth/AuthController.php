<?php
class Auth
{
    private $email;
    private $password;
    private $con;
    private $loginID;
    private $currentLog;
    private $ip;
    private $browser;
    private $os;

    public function __construct(){

        require('db.php');

        $this->db = new mysqli($config['DB_HOST'],$config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE']);
        if($this->checkSession()){

            if($this->currentLog['ip'] != getIP()) 
            
            redirectIfLocked(); 

        }
        
        else redirectIfLocked();
    }
    public function checkSession(){
        $this->loginID = $_COOKIE['auth'];

        $query = mysqli_num_rows($this->db->query("SELECT * from logs where loginID='$this->loginID' and loggedout=0"));

        if($query){
            $this->currentLog = mysqli_fetch_assoc($this->db->query("SELECT * from logs where loginID='$this->loginID' and loggedout=0"));
            return true;
        }

        else return false;

    }
    
    public function login($email, $password){


        $this->email = trim(mysqli_real_escape_string($this->db, $email));
        $this->password = mysqli_real_escape_string($this->db, $password);

        $loginQuery = mysqli_fetch_assoc($this->db->query("SELECT * from users where email='$this->email'"));


        if($loginQuery['password'] == md5($this->password)){


            $this->loginID = md5($this->email.$this->password.time());

            setcookie("auth", $this->loginID, time() + (86400 * 365), "/");

            $this->ip = getDevice()['ip'];
            $this->os = getDevice()['os'];
            $this->browser = getDevice()['browser'];


            $insertLog = $this->db->query("INSERT INTO logs (`loginID`, `email`, `ip`, `browser`, `os`) VALUES ('$this->loginID','$this->email','$this->ip','$this->browser','$this->os')");

            if($insertLog){
                if(!empty($_GET['back'])) header("Location:".$_GET['back']);
                else header("Location:".home());
            }
            else{
                echo "Login Failed";
                //header("Location:".home()."login");
            }
        }
    }
} 

