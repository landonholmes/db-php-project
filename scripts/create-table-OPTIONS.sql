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

INSERT INTO OPTIONS
VALUES
(1,1,'Option 1',1)
,(2,1,'Option 2',0)
,(3,1,'Option 3',0)
,(4,1,'Option 4',0)
,(5,2,'Option 1',0)
,(6,2,'Option 2',1)
,(7,2,'Option 3',1)
,(8,2,'Option 4',0)
,(9,3,'Yes',1)
,(10,3,'No',1)
,(11,3,'Maybe',0)
,(12,5,'Option 1',0)
,(13,5,'Option 2',0)
,(14,6,'Option 1',0)
,(15,6,'Option 2',0)
,(16,6,'Option 3',0)
,(17,6,'Option 4',1);

SET FOREIGN_KEY_CHECKS=1; -- turn that back on