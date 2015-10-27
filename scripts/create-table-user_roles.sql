CREATE DATABASE IF NOT EXISTS DB_PHP;
use DB_PHP;
DROP TABLE IF EXISTS USER_ROLES;

CREATE TABLE USER_ROLES (
	  User_RoleID		INT		NOT NULL auto_increment
	, UserID		    INT		NOT NULL
	, RoleID		    INT		NOT NULL

	, PRIMARY KEY (User_RoleID)
	, UNIQUE KEY User_Roles_IDX0 (UserID, RoleID)
);

/*default admin user is in admin group*/
INSERT INTO USER_ROLES
(
      UserID
    , RoleID
)
VALUES
(
      1
    , 1
);

/*default student user is in student group*/
INSERT INTO USER_ROLES
( UserID, RoleID )
VALUES(2, 2);

/*default manager user is in manager group*/
INSERT INTO USER_ROLES
( UserID, RoleID )
VALUES(3, 3);