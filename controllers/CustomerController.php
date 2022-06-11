<?php
class Customer
{
    protected $customerID;
    protected $name;
    protected $email;
    protected $phone;
    protected $aadhar;
    protected $city;
    protected $pincode;
    protected $address;
    protected $status;
    protected $con;
    public $errors;

    public function __construct(){
        // Require Database
        require('db.php');

        // Database Instantiation
        $this->db = new mysqli($config['DB_HOST'],$config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE']);

        $this->errors = "";

    }

} 

