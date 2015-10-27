CREATE DATABASE IF NOT EXISTS DB_PHP;
use DB_PHP;
DROP TABLE IF EXISTS ROLES;

CREATE TABLE ROLES (
	  RoleID		    INT		        NOT NULL auto_increment
	, RoleName		    VARCHAR(100)	NOT NULL
	, RoleDesc		    VARCHAR(2000)	NOT NULL
	, CreatedOn		    TIMESTAMP		NOT NULL
	, CreatedBy		    INT		        NOT NULL
	, LastModifiedOn	TIMESTAMP		NOT NULL
	, LastModifiedBy	INT		        NOT NULL

	, PRIMARY KEY (RoleID)
	, UNIQUE KEY Roles_IDX0 (RoleName)
);

INSERT INTO ROLES
(
    RoleName
    , RoleDesc
    , CreatedOn
    , CreatedBy
    , LastModifiedOn
    , LastModifiedBy
)
SELECT
    'TEACH'
    , 'Teacher'
    , CURRENT_TIMESTAMP()
    , 1
    , '1970-01-01'
    , 1;

INSERT INTO ROLES
(
    RoleName
    , RoleDesc
    , CreatedOn
    , CreatedBy
    , LastModifiedOn
    , LastModifiedBy
)
SELECT
    'STUDENT'
    , 'Student'
    , CURRENT_TIMESTAMP()
    , 1
    , '1970-01-01'
    , 1;

INSERT INTO ROLES
(
    RoleName
    , RoleDesc
    , CreatedOn
    , CreatedBy
    , LastModifiedOn
    , LastModifiedBy
)
    SELECT
        'USERMANAGE'
        , 'User Management'
        , CURRENT_TIMESTAMP()
        , 1
        , '1970-01-01'
        , 1;
