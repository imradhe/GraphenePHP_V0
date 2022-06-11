CREATE TABLE users (
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    role ENUM ('admin','host','customer') DEFAULT 'customer',
    status ENUM ('active','inactive') DEFAULT 'inactive',
    PRIMARY KEY (email)
);