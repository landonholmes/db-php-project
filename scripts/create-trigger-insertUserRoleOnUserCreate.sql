CREATE DATABASE IF NOT EXISTS DB_PHP;
use DB_PHP;
-- this trigger is to ensure any new users are in the student category by default
DROP TRIGGER IF EXISTS `insertUserRole`;
DELIMITER $$
CREATE TRIGGER `insertUserRole` AFTER INSERT ON `USERS` 
	FOR EACH ROW
    BEGIN
        INSERT INTO USER_ROLES(UserID,RoleID) SELECT new.UserID,2;
    END$$
    DELIMITER ;
