DROP TABLE IF EXISTS user_roles;
use DB_PHP;
CREATE TABLE user_roles (
	  user_roleID		INT		NOT NULL auto_increment
	, userID		    INT		NOT NULL
	, roleID		    INT		NOT NULL

	, PRIMARY KEY (user_roleID)
	, UNIQUE KEY user_roles_IDX0 (userID, roleID)
);


INSERT INTO user_roles
(
      userID
    , roleID
)
VALUES
(
      1
    , 1
);