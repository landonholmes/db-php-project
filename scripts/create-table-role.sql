CREATE DATABASE IF NOT EXISTS DB_PHP;
use DB_PHP;
DROP TABLE IF EXISTS roles;

CREATE TABLE roles (
	  roleID		    INT		        NOT NULL auto_increment
	, roleName		    VARCHAR(100)	NOT NULL
	, roleDesc		    VARCHAR(2000)	NOT NULL
	, createdOn		    TIMESTAMP		NOT NULL
	, createdBy		    INT		        NOT NULL
	, lastModifiedOn	TIMESTAMP		NOT NULL
	, lastModifiedBy	INT		        NOT NULL

	, PRIMARY KEY (roleID)
	, UNIQUE KEY roles_IDX0 (roleName)
);

INSERT INTO roles
(
    roleName
    , roleDesc
    , createdOn
    , createdBy
    , lastModifiedOn
    , lastModifiedBy
)
SELECT
    'ADMIN'
    , 'Administrators'
    , CURRENT_TIMESTAMP()
    , 1
    , '1970-01-01'
    , 1;


INSERT INTO roles
(
    roleName
    , roleDesc
    , createdOn
    , createdBy
    , lastModifiedOn
    , lastModifiedBy
)
SELECT
    'USERMANAGE'
    , 'User Management'
    , CURRENT_TIMESTAMP()
    , 1
    , '1970-01-01'
    , 1;
