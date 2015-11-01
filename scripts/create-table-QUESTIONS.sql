CREATE DATABASE IF NOT EXISTS DB_PHP;
use DB_PHP;
DROP TABLE IF EXISTS QUESTIONS;

CREATE TABLE QUESTIONS (
	  QuestionID		INT		        NOT NULL auto_increment
	, QuizID			INT		        NOT NULL
    , Text		        VARCHAR(2000)	NOT NULL
	, Type				VARCHAR(100)	NOT NULL
	, IsActive		    BIT				NOT NULL
	, PRIMARY KEY (QuestionID)
);
