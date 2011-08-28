DROP TABLE IF EXISTS games;
CREATE TABLE games(
     id INT NOT NULL AUTO_INCREMENT,
     token VARCHAR(5) NOT NULL,
     buzzing BOOLEAN NOT NULL,
     primary key ( id ) );

DROP TABLE IF EXISTS word;
DROP TABLE IF EXISTS words;
DROP TABLE IF EXISTS cards;
CREATE TABLE cards(
     id INT NOT NULL AUTO_INCREMENT,
     game INT NOT NULL,
     title TEXT NOT NULL,
     badwords TEXT NOT NULL,
     active BOOLEAN NOT NULL,
     primary key ( id ) );