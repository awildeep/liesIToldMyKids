CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(100) NOT NULL,
    role VARCHAR(15) NOT NULL
) ENGINE=INNODB;

CREATE TABLE lies (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    date TIMESTAMP NOT NULL,
    description TEXT NOT NULL,
    user_id INT NOT NULL,
    valid SMALLINT NOT NULL
) ENGINE=INNODB;

ALTER TABLE lies ADD CONSTRAINT
    FOREIGN KEY (user_id)
    REFERENCES users(id);