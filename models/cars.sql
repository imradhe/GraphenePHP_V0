CREATE TABLE cars (
    carID varchar(255) NOT NULL,
    hostID varchar(255) NOT NULL,
    model varchar(255) NOT NULL,
    carNumber varchar(255) NOT NULL,
    photo varchar(255) NOT NULL,
    seats int NOT NULL,
    rent int NOT NULL,
    status ENUM ('available','booked','removed') DEFAULT 'available',
    FOREIGN KEY (hostID) REFERENCES hosts(hostID),
    PRIMARY KEY (carID)
);