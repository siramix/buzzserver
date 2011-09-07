DROP TABLE IF EXISTS games;
DROP TABLE IF EXISTS players;
DROP TABLE IF EXISTS word;
DROP TABLE IF EXISTS words;
DROP TABLE IF EXISTS cards;

CREATE TABLE games(
     id INT NOT NULL AUTO_INCREMENT,
     token VARCHAR(5) NOT NULL UNIQUE,
     location Point NOT NULL,
     start_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     buzzing BOOLEAN NOT NULL,
     primary key ( id ),
     SPATIAL INDEX(location) )
     Engine='MyISAM';

CREATE TABLE cards(
     id INT NOT NULL AUTO_INCREMENT,
     game INT NOT NULL,
     title TEXT NOT NULL,
     badwords TEXT NOT NULL,
     active BOOLEAN NOT NULL,
     primary key ( id ) );
