DROP TABLE IF EXISTS games;
CREATE TABLE games(
     id INT NOT NULL AUTO_INCREMENT,
     token VARCHAR(5) NOT NULL,
     primary key ( id ) );

DROP TABLE IF EXISTS words;
CREATE TABLE word(
     id INT NOT NULL AUTO_INCREMENT,
     game INT NOT NULL,
     wordid INT NOT NULL,
     status INT NOT NULL,
     primary key ( id ) );