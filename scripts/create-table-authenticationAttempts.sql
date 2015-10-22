CREATE DATABASE IF NOT EXISTS DB_PHP;
use DB_PHP;
DROP TABLE IF EXISTS authenticationAttempts;

CREATE TABLE authenticationAttempts (
	  attemptID		    BIGINT		    NOT NULL auto_increment
	, username		    VARCHAR(200)	NOT NULL
	, wasSuccessful		TINYINT(1)		NOT NULL
	, attemptedOn		TIMESTAMP		NOT NULL
	, attemptedIP		VARCHAR(50)		NOT NULL

	, PRIMARY KEY (attemptID)
);
