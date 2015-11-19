CREATE DATABASE  IF NOT EXISTS `DB_PHP` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `DB_PHP`;
-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- Host: 45.55.227.51    Database: DB_PHP
-- ------------------------------------------------------
-- Server version	5.5.44-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `OPTIONS`
--

DROP TABLE IF EXISTS `OPTIONS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `OPTIONS` (
  `OptionID` int(11) NOT NULL AUTO_INCREMENT,
  `QuestionID` int(11) NOT NULL,
  `Text` varchar(2000) NOT NULL,
  `IsAnswer` bit(1) NOT NULL,
  PRIMARY KEY (`OptionID`),
  KEY `Options_QuestionFK` (`QuestionID`),
  CONSTRAINT `Options_QuestionFK` FOREIGN KEY (`QuestionID`) REFERENCES `QUESTIONS` (`QuestionID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OPTIONS`
--

LOCK TABLES `OPTIONS` WRITE;
/*!40000 ALTER TABLE `OPTIONS` DISABLE KEYS */;
INSERT INTO `OPTIONS` VALUES (1,1,'Option 1',''),(2,1,'Option 2','\0'),(3,1,'Option 3','\0'),(4,1,'Option 4','\0'),(5,2,'Option 1','\0'),(6,2,'Option 2',''),(7,2,'Option 3',''),(8,2,'Option 4','\0'),(9,3,'Yes',''),(10,3,'No',''),(11,3,'Maybe','\0'),(12,5,'Option 1','\0'),(13,5,'Option 2','\0'),(14,6,'Option 1','\0'),(15,6,'Option 2','\0'),(16,6,'Option 3','\0'),(17,6,'Option 4','');
/*!40000 ALTER TABLE `OPTIONS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `QUESTIONS`
--

DROP TABLE IF EXISTS `QUESTIONS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `QUESTIONS` (
  `QuestionID` int(11) NOT NULL AUTO_INCREMENT,
  `QuizID` int(11) NOT NULL,
  `Text` varchar(2000) NOT NULL,
  `Type` varchar(100) NOT NULL,
  `IsActive` bit(1) NOT NULL,
  PRIMARY KEY (`QuestionID`),
  KEY `Question_QuizFK` (`QuizID`),
  CONSTRAINT `Question_QuizFK` FOREIGN KEY (`QuizID`) REFERENCES `QUIZ` (`QuizID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `QUESTIONS`
--

LOCK TABLES `QUESTIONS` WRITE;
/*!40000 ALTER TABLE `QUESTIONS` DISABLE KEYS */;
INSERT INTO `QUESTIONS` VALUES (1,1,'Choose option 1','Select',''),(2,1,'Choose Option 2 or 3','Select',''),(3,1,'Type \"Yes\" or \"No\"','Text',''),(4,1,'Question with no OPTIONS','Select',''),(5,1,'Question that is disabled','Select','\0'),(6,1,'Choose Option 4','Radio','');
/*!40000 ALTER TABLE `QUESTIONS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `QUIZ`
--

DROP TABLE IF EXISTS `QUIZ`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `QUIZ` (
  `QuizID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Description` varchar(2000) NOT NULL,
  `IsActive` bit(1) NOT NULL,
  PRIMARY KEY (`QuizID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `QUIZ`
--

LOCK TABLES `QUIZ` WRITE;
/*!40000 ALTER TABLE `QUIZ` DISABLE KEYS */;
INSERT INTO `QUIZ` VALUES (1,'Test 1','A Test 1 Sample Quiz Thing','');
/*!40000 ALTER TABLE `QUIZ` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RESPONSES`
--

DROP TABLE IF EXISTS `RESPONSES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RESPONSES` (
  `ResponseID` int(11) NOT NULL AUTO_INCREMENT,
  `QuizID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `QuestionText` varchar(2000) NOT NULL,
  `QuestionID` int(11) NOT NULL,
  `OptionText` varchar(2000) NOT NULL,
  `OptionID` int(11) NOT NULL,
  `Response` varchar(2000) NOT NULL,
  `CorrectResponse` varchar(2000) NOT NULL,
  `IsCorrect` bit(1) NOT NULL,
  `ResponseOn` datetime NOT NULL,
  PRIMARY KEY (`ResponseID`),
  KEY `Reponse_QuizFK` (`QuizID`),
  KEY `Reponse_UserFK` (`UserID`),
  KEY `Reponse_QuestionFK` (`QuestionID`),
  KEY `Reponse_OptionFK` (`OptionID`),
  CONSTRAINT `Reponse_OptionFK` FOREIGN KEY (`OptionID`) REFERENCES `OPTIONS` (`OptionID`),
  CONSTRAINT `Reponse_QuestionFK` FOREIGN KEY (`QuestionID`) REFERENCES `QUESTIONS` (`QuestionID`),
  CONSTRAINT `Reponse_QuizFK` FOREIGN KEY (`QuizID`) REFERENCES `QUIZ` (`QuizID`),
  CONSTRAINT `Reponse_UserFK` FOREIGN KEY (`UserID`) REFERENCES `USERS` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RESPONSES`
--

LOCK TABLES `RESPONSES` WRITE;
/*!40000 ALTER TABLE `RESPONSES` DISABLE KEYS */;
/*!40000 ALTER TABLE `RESPONSES` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ROLES`
--

DROP TABLE IF EXISTS `ROLES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ROLES` (
  `RoleID` int(11) NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(100) NOT NULL,
  `RoleDesc` varchar(2000) NOT NULL,
  PRIMARY KEY (`RoleID`),
  UNIQUE KEY `Roles_IDX0` (`RoleName`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ROLES`
--

LOCK TABLES `ROLES` WRITE;
/*!40000 ALTER TABLE `ROLES` DISABLE KEYS */;
INSERT INTO `ROLES` VALUES (1,'TEACH','Teacher'),(2,'STUDENT','Student'),(3,'USERMANAGE','User Management');
/*!40000 ALTER TABLE `ROLES` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `USERS`
--

DROP TABLE IF EXISTS `USERS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `USERS` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(200) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `FirstName` varchar(200) NOT NULL,
  `LastName` varchar(200) NOT NULL,
  `Password` varchar(512) NOT NULL,
  `PasswordLastSetOn` datetime NOT NULL,
  `PasswordLastSetBy` int(11) NOT NULL,
  `PasswordLastSetByIP` varchar(50) NOT NULL,
  `LastLoggedInOn` datetime NOT NULL,
  `IsLocked` bit(1) NOT NULL,
  `CreatedOn` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedByIP` varchar(50) NOT NULL,
  `LastModifiedOn` datetime NOT NULL,
  `LastModifiedBy` int(11) NOT NULL,
  `LastModifiedByIP` varchar(50) NOT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `UserAK1` (`Username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USERS`
--

LOCK TABLES `USERS` WRITE;
/*!40000 ALTER TABLE `USERS` DISABLE KEYS */;
INSERT INTO `USERS` VALUES (1,'teacher','teacher@example.com','Teacher','User','sha256:1000:uoJNHMPp14mpES0B+fn7LASxTR/NYtNu:S0PfZhtY2w68lRQf575pfpskVLhZsXyL','2015-11-05 13:24:28',1,'0.0.0.0','2015-11-12 13:18:42','\0','2015-11-05 13:24:28',1,'0.0.0.0','1970-01-01 00:00:00',1,'0.0.0.0'),(2,'student','student@example.com','Student','User','sha256:1000:uoJNHMPp14mpES0B+fn7LASxTR/NYtNu:S0PfZhtY2w68lRQf575pfpskVLhZsXyL','2015-11-05 13:24:29',1,'0.0.0.0','2015-11-12 13:17:33','\0','2015-11-05 13:24:29',1,'0.0.0.0','1970-01-01 00:00:00',1,'0.0.0.0'),(3,'manager','manager@example.com','Manager','User','sha256:1000:uoJNHMPp14mpES0B+fn7LASxTR/NYtNu:S0PfZhtY2w68lRQf575pfpskVLhZsXyL','2015-11-05 13:24:29',1,'0.0.0.0','2015-11-12 13:19:29','\0','2015-11-05 13:24:29',1,'0.0.0.0','1970-01-01 00:00:00',1,'0.0.0.0');
/*!40000 ALTER TABLE `USERS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `USER_ROLES`
--

DROP TABLE IF EXISTS `USER_ROLES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `USER_ROLES` (
  `User_RoleID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL,
  PRIMARY KEY (`User_RoleID`),
  UNIQUE KEY `User_Roles_IDX0` (`UserID`,`RoleID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USER_ROLES`
--

LOCK TABLES `USER_ROLES` WRITE;
/*!40000 ALTER TABLE `USER_ROLES` DISABLE KEYS */;
INSERT INTO `USER_ROLES` VALUES (1,1,1),(2,2,2),(3,3,3),(4,4,2),(5,8,2);
/*!40000 ALTER TABLE `USER_ROLES` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'DB_PHP'
--

--
-- Dumping routines for database 'DB_PHP'
--
/*!50003 DROP FUNCTION IF EXISTS `getNameDisplay` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `getNameDisplay`(FirstName VARCHAR(200),LastName VARCHAR(200)) RETURNS varchar(400) CHARSET latin1
    DETERMINISTIC
BEGIN
        DECLARE FullName VARCHAR(400);

        SET FullName = CONCAT(TRIM(LastName),',',TRIM(FirstName));

        RETURN FullName;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `OPTIONS_AddOption` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`landon`@`%` PROCEDURE `OPTIONS_AddOption`(aQuestionID INT,aText VARCHAR(2000),aIsAnswer BIT)
BEGIN
        DECLARE RowCount INT;

        SELECT COUNT(*) INTO RowCount
        FROM QUESTIONS
        WHERE QuestionID = aQuestionID;
        
        IF (RowCount = 0) THEN
			BEGIN
				SIGNAL SQLSTATE '40000'
				SET MESSAGE_TEXT = 'An error occurred. No Question found for that QuestionID.';
            END;
		ELSE  
			BEGIN
				INSERT INTO OPTIONS(QuestionID,Text,IsAnswer)
                VALUES (aQuestionID,aText,aIsAnswer);
            END;
		END IF;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `QUESTIONS_AddQuestion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`landon`@`%` PROCEDURE `QUESTIONS_AddQuestion`(aQuizID INT,aText VARCHAR(2000),aType VARCHAR(100),aIsActive BIT)
BEGIN
        DECLARE RowCount INT;

        SELECT COUNT(*) INTO RowCount
        FROM QUIZ
        WHERE QuizID = aQuizID;
        
        IF (RowCount = 0) THEN
			BEGIN
				SIGNAL SQLSTATE '40000'
				SET MESSAGE_TEXT = 'An error occurred. No Quiz found for that QuizID.';
            END;
		ELSE  
			BEGIN
				INSERT INTO QUESTIONS(QuizID,Text,Type,IsActive)
                VALUES (aQuizID,aText,aType,aIsActive);
            END;
		END IF;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `QUIZ_AddQuiz` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`landon`@`%` PROCEDURE `QUIZ_AddQuiz`(aName VARCHAR(100),aDescription VARCHAR(2000),aIsActive BIT)
BEGIN
        DECLARE RowCount INT;
        
		BEGIN
			INSERT INTO QUIZ(Name,Description,IsActive)
			VALUES (aName,aDescription,aIsActive);
		END;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `RESPONSES_AddReponse` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`landon`@`%` PROCEDURE `RESPONSES_AddReponse`(
		aQuizID INT 					-- quiz is required
		,aUserID INT 					-- user is required
		,aQuestionText VARCHAR(2000)	
		,aQuestionID INT 				-- question is required
		,aOptionText VARCHAR(2000)
		,aOptionID INT 				-- option is optional (haha)
		,aResponse VARCHAR(2000)
		,aCorrectResponse VARCHAR(2000)
        ,aIsCorrect BIT
        ,aResponseOn DATETIME
    )
BEGIN
        DECLARE RowCount INT;
		-- first check for the quiz
		SELECT COUNT(*) INTO RowCount
        FROM QUIZ
        WHERE QuizID = aQuizID;
        
        IF (RowCount = 0) THEN
			BEGIN
				SIGNAL SQLSTATE '40000'
				SET MESSAGE_TEXT = 'An error occurred. No Quiz found for that QuizID.';
            END;
		ELSE  
			BEGIN -- next check for the user
				SELECT COUNT(*) INTO RowCount
				FROM USERS
				WHERE UserID = aUserID;
                
				IF (RowCount = 0) THEN
					BEGIN
						SIGNAL SQLSTATE '41000'
						SET MESSAGE_TEXT = 'An error occurred. No User found for that UserID.';
					END;
				ELSE  
					BEGIN -- findal check for the question
						SELECT COUNT(*) INTO RowCount
						FROM QUESTIONS
						WHERE QuestionID = aQuestionID;
                
						IF (RowCount = 0) THEN
							BEGIN
								SIGNAL SQLSTATE '42000'
								SET MESSAGE_TEXT = 'An error occurred. No Question found for that QuestionID.';
							END;
						ELSE  
							BEGIN -- passes all checks, we can insert it
								INSERT INTO RESPONSES (QuizID,UserID,QuestionText,QuestionID,OptionText,OptionID,Response,CorrectResponse,IsCorrect,ResponseOn)
								VALUES (aQuizID,aUserID,aQuestionText,aQuestionID,aOptionText,aOptionID,aResponse,aCorrectResponse,aIsCorrect,aResponseOn);
							END;
						END IF;
					END;
				END IF;
            END;
		END IF;
        
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ROLES_AddRole` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`landon`@`%` PROCEDURE `ROLES_AddRole`(aRoleName VARCHAR(100),aRoleDesc VARCHAR(2000))
BEGIN
        DECLARE RowCount INT;
        
		INSERT INTO ROLES (RoleName,RoleDesc)
		VALUES (aRoleName,aRoleDesc);
			
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `USERS_AddUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`landon`@`%` PROCEDURE `USERS_AddUser`(
		aUsername		            VARCHAR(200)	
		,aEmail		                VARCHAR(200)
		,aFirstName		            VARCHAR(200)
		,aLastName		            VARCHAR(200)
		,aPassword		            VARCHAR(512)
		,aPasswordLastSetOn		    DATETIME
		,aPasswordLastSetBy		    INT	
		,aPasswordLastSetByIP		VARCHAR(50)	
		,aLastLoggedInOn		    DATETIME
		,aIsLocked		            BIT 	
		,aCreatedOn		            DATETIME	
		,aCreatedBy		            INT		 
		,aCreatedByIP		        VARCHAR(50)	
		,aLastModifiedOn		    DATETIME	
		,aLastModifiedBy		    INT		     
		,aLastModifiedByIP		    VARCHAR(50)
	)
BEGIN
        DECLARE RowCount INT;
        
        SELECT COUNT(*) into RowCount 
        FROM USERS
        WHERE Username = aUsername;
        
        IF (RowCount != 0) THEN
			SIGNAL SQLSTATE '40000'
			SET MESSAGE_TEXT = 'An error occurred. That username is already taken.';
		ELSE
			INSERT INTO USERS
				(
					Username		/*  - varchar(256)*/
					, Email			/*  - varchar(256)*/
					, FirstName		/*  - varchar(100)*/
					, LastName		/*  - varchar(100)*/
					, Password		/*  - varchar(1000)*/
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
					aUsername,aEmail
                    ,aFirstName
                    ,aLastName
                    ,aPassword
                    ,aPasswordLastSetOn
                    ,PasswordLastSetBy	
					, PasswordLastSetByIP	/*  - varchar(50)*/
					, LastLoggedInOn	/*  - datetime*/
					, IsLocked          /*  - bit*/
					, CreatedOn		/*  - datetime*/
					, CreatedBy		/*  - varchar(100)*/
					, CreatedByIP		/*  - varchar(50)*/
					, LastModifiedOn	/*  - datetime*/
					, LastModifiedBy	/*  - varchar(100)*/
					, LastModifiedByIP	/*  - varchar(50)*/
				);
        END IF;
        
			
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `USER_ROLES_AddUserRole` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`landon`@`%` PROCEDURE `USER_ROLES_AddUserRole`(aUserID INT,aRoleID INT)
BEGIN
        DECLARE RowCount INT;
        
        SELECT COUNT(*) INTO RowCount
		FROM USERS
		WHERE UserID = aUserID;
        
		IF (RowCount = 0) THEN
			SIGNAL SQLSTATE '40000'
			SET MESSAGE_TEXT = 'An error occurred. No User found for that UserID.';
		ELSE  -- next check for the user
			SELECT COUNT(*) INTO RowCount
			FROM ROLES
			WHERE RoleID = aRoleID;
                
			IF (RowCount = 0) THEN
				SIGNAL SQLSTATE '41000'
				SET MESSAGE_TEXT = 'An error occurred. No Role found for that RoleID.';
			ELSE  -- make sure the relationship doesn't already exist
				SELECT COUNT(*) INTO RowCount
				FROM USER_ROLES
				WHERE UserID = aUserID AND RoleID = aRoleID;
                
				IF (RowCount != 0) THEN
					SIGNAL SQLSTATE '41000'
					SET MESSAGE_TEXT = 'An error occurred. No User-Role relationship already exists.';
				ELSE 
					INSERT INTO USER_ROLES(UserID,RoleID)
					VALUES (aUserID,aRoleID);
				END IF;
			END IF;
		END IF;
        
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-19  8:14:32
