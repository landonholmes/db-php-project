CREATE DATABASE IF NOT EXISTS DB_PHP;
use DB_PHP;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
      userID		            INT		        NOT NULL auto_increment
    , username		            VARCHAR(200)	NOT NULL
    , email		                VARCHAR(200)	NOT NULL
    , firstName		            VARCHAR(200)	NOT NULL
    , lastName		            VARCHAR(200)	NOT NULL
    , password		            VARCHAR(512)	NOT NULL
    , isPasswordExpired		    TINYINT(1)		NOT NULL
    , passwordLastSetOn		    TIMESTAMP		NOT NULL
    , passwordLastSetBy		    INT		        NOT NULL
    , passwordLastSetByIP		VARCHAR(50)		NOT NULL
    , lastLoggedInOn		    TIMESTAMP		NOT NULL
    , isLocked		            TINYINT(1)		NOT NULL
    , createdOn		            TIMESTAMP		NOT NULL
    , createdBy		            INT		        NOT NULL
    , createdByIP		        VARCHAR(50)		NOT NULL
    , lastModifiedOn		    TIMESTAMP		NOT NULL
    , lastModifiedBy		    INT		        NOT NULL
    , lastModifiedByIP		    VARCHAR(50)		NOT NULL

    , PRIMARY KEY (userID)
);

INSERT INTO users
(
    username		/*  - varchar(256)*/
    , email			/*  - varchar(256)*/
    , firstName		/*  - varchar(100)*/
    , lastName		/*  - varchar(100)*/
    , password		/*  - varchar(1000)*/
    , isPasswordExpired	/*  - bit*/
    , passwordLastSetOn	/*  - datetime*/
    , passwordLastSetBy	/*  - varchar(100)*/
    , passwordLastSetByIP	/*  - varchar(50)*/
    , lastLoggedInOn	/*  - datetime*/
    , isLocked          /*  - bit*/
    , createdOn		/*  - datetime*/
    , createdBy		/*  - varchar(100)*/
    , createdByIP		/*  - varchar(50)*/
    , lastModifiedOn	/*  - datetime*/
    , lastModifiedBy	/*  - varchar(100)*/
    , lastModifiedByIP	/*  - varchar(50)*/
)
VALUES
(
    'landon'	/* username - varchar (256) */
    , 'landon.holmes@gmail.com'	/* email - varchar (256) */
    , 'Landon'	/* firstName - varchar (100) */
    , 'Holmes'	/* lastName - varchar (100) */
    , '100000:6B68354F248FEC6E:39ADBEDA442763781DB9A3B22D010EE15D0F3FDE'
    , 0	/* isPasswordExpired - bit */
    , CURRENT_TIMESTAMP()	/* passwordLastSetOn - datetime */
    , 1	/* passwordLastSetBy - varchar (100) */
    , '0.0.0.0'	/* passwordLastSetByIP - varchar (50) */
    , '1970-01-01'	/* lastLoggedInOn - datetime */
    , 0 /* isLocked - bit */
    , CURRENT_TIMESTAMP()	/* createdOn - datetime */
    , 1	/* createdBy - varchar (100) */
    , '0.0.0.0'	/* createdByIP - varchar (50) */
    , '1970-01-01'	/* lastModifiedOn - datetime */
    , 1	/* lastModifiedBy - varchar (100) */
    , '0.0.0.0'	/* lastModifiedByIP - varchar (50) */
);

