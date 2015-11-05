CREATE DATABASE IF NOT EXISTS DB_PHP;
use DB_PHP;

SET FOREIGN_KEY_CHECKS=0; -- it'll complain when we drop it to recreate it

DROP TABLE IF EXISTS OPTIONS;
CREATE TABLE OPTIONS (
	  OptionID			INT		        NOT NULL auto_increment
	, QuestionID	    INT				NOT NULL
	, Text				VARCHAR(2000)	NOT NULL
	, IsAnswer			BIT				NOT NULL
	, CONSTRAINT 		OptionPK		PRIMARY KEY (OptionID)
	, CONSTRAINT 		Options_QuestionFK		FOREIGN KEY (QuestionID) REFERENCES QUESTIONS(QuestionID)
);

SET FOREIGN_KEY_CHECKS=1; -- turn that back on