CREATE TABLE logs (
    loginID varchar(32) NOT NULL,
    username varchar(30) NOT NULL,
    last TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    browser varchar(32) NOT NULL,
    loggedout int DEFAULT 0,
    loggedoutat TIMESTAMP NULL,
    FOREIGN KEY (username) REFERENCES users(username),
    PRIMARY KEY (loginID)
);