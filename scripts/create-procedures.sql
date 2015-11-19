CREATE DATABASE IF NOT EXISTS DB_PHP;
use DB_PHP;

DROP PROCEDURE IF EXISTS OPTIONS_AddOption;
DELIMITER $$
CREATE PROCEDURE OPTIONS_AddOption(aQuestionID INT,aText VARCHAR(2000),aIsAnswer BIT)
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
    END$$
DELIMITER ;


DROP PROCEDURE IF EXISTS QUESTIONS_AddQuestion;
DELIMITER $$
CREATE PROCEDURE QUESTIONS_AddQuestion(aQuizID INT,aText VARCHAR(2000),aType VARCHAR(100),aIsActive BIT)
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
    END$$
DELIMITER ;


DROP PROCEDURE IF EXISTS QUIZ_AddQuiz;
DELIMITER $$
CREATE PROCEDURE QUIZ_AddQuiz(aName VARCHAR(100),aDescription VARCHAR(2000),aIsActive BIT)
    BEGIN
        DECLARE RowCount INT;
        
		BEGIN
			INSERT INTO QUIZ(Name,Description,IsActive)
			VALUES (aName,aDescription,aIsActive);
		END;
    END$$
DELIMITER ;


DROP PROCEDURE IF EXISTS RESPONSES_AddReponse;
DELIMITER $$
CREATE PROCEDURE RESPONSES_AddReponse
	(
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
        
    END$$
DELIMITER ;


DROP PROCEDURE IF EXISTS ROLES_AddRole;
DELIMITER $$
CREATE PROCEDURE ROLES_AddRole(aRoleName VARCHAR(100),aRoleDesc VARCHAR(2000))
    BEGIN
        DECLARE RowCount INT;
        
		INSERT INTO ROLES (RoleName,RoleDesc)
		VALUES (aRoleName,aRoleDesc);
			
    END$$
DELIMITER ;


DROP PROCEDURE IF EXISTS USER_ROLES_AddUserRole;
DELIMITER $$
CREATE PROCEDURE USER_ROLES_AddUserRole(aUserID INT,aRoleID INT) -- both required
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
        
    END$$
DELIMITER ;


DROP PROCEDURE IF EXISTS USERS_AddUser;
DELIMITER $$
CREATE PROCEDURE USERS_AddUser
	(
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
        
			
    END$$
DELIMITER ;



