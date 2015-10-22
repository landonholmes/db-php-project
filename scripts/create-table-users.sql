CREATE DATABASE IF NOT EXISTS DB_PHP;
use DB_PHP;
DROP TABLE IF EXISTS USERS;

CREATE TABLE USERS (
      UserID		            INT		        NOT NULL auto_increment
    , Username		            VARCHAR(200)	NOT NULL
    , Email		                VARCHAR(200)	NOT NULL
    , FirstName		            VARCHAR(200)	NOT NULL
    , LastName		            VARCHAR(200)	NOT NULL
    , Password		            VARCHAR(512)	NOT NULL
    , IsPasswordExpired		    TINYINT(1)		NOT NULL
    , PasswordLastSetOn		    TIMESTAMP		NOT NULL
    , PasswordLastSetBy		    INT		        NOT NULL
    , PasswordLastSetByIP		VARCHAR(50)		NOT NULL
    , LastLoggedInOn		    TIMESTAMP		NOT NULL
    , IsLocked		            TINYINT(1)		NOT NULL
    , CreatedOn		            TIMESTAMP		NOT NULL
    , CreatedBy		            INT		        NOT NULL
    , CreatedByIP		        VARCHAR(50)		NOT NULL
    , LastModifiedOn		    TIMESTAMP		NOT NULL
    , LastModifiedBy		    INT		        NOT NULL
    , LastModifiedByIP		    VARCHAR(50)		NOT NULL

    , PRIMARY KEY (userID)
);

INSERT INTO USERS
(
    uUsername		/*  - varchar(256)*/
    , Email			/*  - varchar(256)*/
    , FirstName		/*  - varchar(100)*/
    , LastName		/*  - varchar(100)*/
    , Password		/*  - varchar(1000)*/
    , IsPasswordExpired	/*  - bit*/
    , PasswordLastSetOn	/*  - datetime*/
    , PasswordLastSetBy	/*  - varchar(100)*/
    , PasswordLastSetByIP	/*  - varchar(50)*/
    , LastLoggedInOn	/*  - datetime*/
    , IsLocked          /*  - bit*/
    , CreatedOn		/*  - datetime*/
    , CreatedBy		/*  - varchar(100)*/
    , CreatedByIP		/*  - varchar(50)*/
    , LastModifiedOn	/*  - datetime*/
    , LastModifiedBy	/*  - varchar(100)*/
    , LastModifiedByIP	/*  - varchar(50)*/
)
VALUES
(
    'landon'	/* Username - varchar (256) */
    , 'landon.holmes@gmail.com'	/* Email - varchar (256) */
    , 'Landon'	/* FirstName - varchar (100) */
    , 'Holmes'	/* LastName - varchar (100) */
    , '100000:6B68354F248FEC6E:39ADBEDA442763781DB9A3B22D010EE15D0F3FDE'
    , 0	/* IsPasswordExpired - bit */
    , CURRENT_TIMESTAMP()	/* PasswordLastSetOn - datetime */
    , 1	/* PasswordLastSetBy - varchar (100) */
    , '0.0.0.0'	/* PasswordLastSetByIP - varchar (50) */
    , '1970-01-01'	/* LastLoggedInOn - datetime */
    , 0 /* IsLocked - bit */
    , CURRENT_TIMESTAMP()	/* CreatedOn - datetime */
    , 1	/* CreatedBy - varchar (100) */
    , '0.0.0.0'	/* CreatedByIP - varchar (50) */
    , '1970-01-01'	/* LastModifiedOn - datetime */
    , 1	/* LastModifiedBy - varchar (100) */
    , '0.0.0.0'	/* LastModifiedByIP - varchar (50) */
);

