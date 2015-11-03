CREATE DATABASE IF NOT EXISTS DB_PHP;
use DB_PHP;
DROP TABLE IF EXISTS RESPONSES;

CREATE TABLE RESPONSES (
	  ResponseID		INT		        NOT NULL auto_increment
    , QuizID		    INT				NOT NULL
	, UserID			INT				NOT NULL
	, QuestionText		VARCHAR(2000)	NOT NULL
	, QuestionID		INT				NOT NULL
	, OptionText		VARCHAR(2000)	NOT NULL
	, OptionID			INT				NOT NULL
	, Response			VARCHAR(2000)	NOT NULL
	, CorrectResponse	VARCHAR(2000)	NOT NULL
	, IsCorrect			BIT				NOT NULL
	, ResponseOn	    DATETIME		NOT NULL
	, PRIMARY KEY (ResponseID)
);
