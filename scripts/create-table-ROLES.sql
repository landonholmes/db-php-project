CREATE DATABASE IF NOT EXISTS DB_PHP;
use DB_PHP;

SET FOREIGN_KEY_CHECKS=0; -- it'll complain when we drop it to recreate it

DROP TABLE IF EXISTS ROLES;
CREATE TABLE ROLES (
	  RoleID		    INT		        NOT NULL auto_increment
	, RoleName		    VARCHAR(100)	NOT NULL
	, RoleDesc		    VARCHAR(2000)	NOT NULL
	, CONSTRAINT        RolePK          PRIMARY KEY (RoleID)
	, CONSTRAINT        Roles_IDX0      UNIQUE KEY (RoleName)
);

SET FOREIGN_KEY_CHECKS=1; -- turn that back on

INSERT INTO ROLES
(
    RoleName
    , RoleDesc
)
SELECT
    'TEACH'
    , 'Teacher';

INSERT INTO ROLES
(
    RoleName
    , RoleDesc
)
SELECT
    'STUDENT'
    , 'Student';

INSERT INTO ROLES
(
    RoleName
    , RoleDesc
)
    SELECT
        'USERMANAGE'
        , 'User Management'
