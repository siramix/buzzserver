DROP TABLE IF EXISTS games;
CREATE TABLE games(
     id INT NOT NULL AUTO_INCREMENT,
     token VARCHAR(5) NOT NULL,
     buzzing BOOLEAN NOT NULL,
     primary key ( id ) );

DROP TABLE IF EXISTS words;
CREATE TABLE words(
     id INT NOT NULL AUTO_INCREMENT,
     game INT NOT NULL,
     wordtext TEXT NOT NULL,
     status INT NOT NULL,
     primary key ( id ) );