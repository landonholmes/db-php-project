CREATE DATABASE IF NOT EXISTS DB_PHP;
use DB_PHP;

SET FOREIGN_KEY_CHECKS=0; -- it'll complain when we drop it to recreate it

DROP TABLE IF EXISTS QUIZ;
CREATE TABLE QUIZ (
	  QuizID		    INT		        NOT NULL auto_increment
    , Name		        VARCHAR(100)	NOT NULL
	, Description		VARCHAR(2000)	NOT NULL
	, IsActive		    BIT				NOT NULL
	, CONSTRAINT		QuizPK			PRIMARY KEY (QuizID)
);

SET FOREIGN_KEY_CHECKS=1; -- turn that back on