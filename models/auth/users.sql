CREATE TABLE users (
    username varchar(30) NOT NULL,
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    role ENUM ('user','moderator','admin') DEFAULT 'user',
    status int DEFAULT 0,
    PRIMARY KEY (username)
);