CREATE DATABASE IF NOT EXISTS DB_PHP;
use DB_PHP;
DROP TABLE IF EXISTS ROLES;

CREATE TABLE ROLES (
	  RoleID		    INT		        NOT NULL auto_increment
	, RoleName		    VARCHAR(100)	NOT NULL
	, RoleDesc		    VARCHAR(2000)	NOT NULL
	, PRIMARY KEY (RoleID)
	, UNIQUE KEY Roles_IDX0 (RoleName)
);

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
