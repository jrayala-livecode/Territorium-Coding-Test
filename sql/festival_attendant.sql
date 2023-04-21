CREATE TABLE IF NOT EXISTS attendants (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    age INT(11) NOT NULL,
    gender ENUM('male', 'female', 'undefined') NOT NULL,
    nationality VARCHAR(50) NOT NULL,
    ticket_type ENUM('general', 'vip', 'backstage') NOT NULL,
    PRIMARY KEY (id)
    UNIQUE KEY unique_email (email)
);