CREATE TABLE bookings (
    bookingID varchar(255) NOT NULL,
    carID varchar(255) NOT NULL,
    customerID varchar(255) NOT NULL,
    hostID varchar(255) NOT NULL,
    startDate varchar(255) NOT NULL,
    numDays int NOT NULL,
    totalPrice int NOT NULL,
    bookedat timestamp NOT NULL DEFAULT current_timestamp(),
    status enum('active','cancelled') DEFAULT 'active',
    PRIMARY KEY (bookingID),
    FOREIGN KEY (carID) REFERENCES cars(carID),
    FOREIGN KEY (customerID) REFERENCES customers(customerID),
    FOREIGN KEY (hostID) REFERENCES hosts(hostID)
);