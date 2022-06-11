CREATE TABLE customers (
    customerID varchar(255) NOT NULL,
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    phone varchar(10) NOT NULL,
    aadhar varchar(12) NOT NULL,
    city varchar(255) NOT NULL,
    pincode varchar(6) NOT NULL,
    address text NOT NULL,
    status ENUM ('unverified','aadhar_verified','phone_verified') DEFAULT 'unverified',
    PRIMARY KEY (customerID)
);