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
    ,CONSTRAINT			Question_QuizFK	FOREIGN KEY (QuizID) REFERENCES QUIZ(QuizID)
);


INSERT INTO QUESTIONS
VALUES
(1,1,'Choose option 1','Select',1)
,(2,1,'Choose Option 2 or 3','Select',1)
,(3,1,'Type \"Yes\" or \"No\"','Text',1)
,(4,1,'Question with no OPTIONS','Select',1)
,(5,1,'Question that is disabled','Select',0)
,(6,1,'Choose Option 4','Radio',1);

SET FOREIGN_KEY_CHECKS=1; -- turn that back on 