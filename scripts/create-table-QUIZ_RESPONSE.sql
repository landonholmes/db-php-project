CREATE DATABASE IF NOT EXISTS DB_PHP;
use DB_PHP;
DROP TABLE IF EXISTS QUIZ_RESPONSE;

CREATE TABLE QUIZ_RESPONSE (
	  ResponseID		INT		        NOT NULL auto_increment
    , QuizID		    INT				NOT NULL
	, UserID			INT				NOT NULL
	, QuestionText		VARCHAR(2000)	NOT NULL
	, QuestionID		INT				NOT NULL
	, OptionText		VARCHAR(2000)	NOT NULL
	, QuestionOptionID	INT				NOT NULL
	, Response			VARCHAR(2000)	NOT NULL
	, IsCorrect			BIT				NOT NULL
	, ResponseOn	    TIMESTAMP		NOT NULL
	, PRIMARY KEY (ResponseID)
);
