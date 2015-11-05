CREATE DATABASE IF NOT EXISTS DB_PHP;
use DB_PHP;

SET FOREIGN_KEY_CHECKS=0; -- it'll complain when we drop it to recreate it

DROP TABLE IF EXISTS QUESTIONS;
CREATE TABLE QUESTIONS (
	  QuestionID		INT		        NOT NULL auto_increment
	, QuizID			INT		        NOT NULL
    , Text		        VARCHAR(2000)	NOT NULL
	, Type				VARCHAR(100)	NOT NULL
	, IsActive		    BIT				NOT NULL
	,CONSTRAINT 		QuestionPK 		PRIMARY KEY (QuestionID)
);

SET FOREIGN_KEY_CHECKS=1; -- turn that back on 
