<?php

if (file_exists("../models/question.php")) {
    include_once "../models/question.php";
} else if (file_exists("models/question.php")) {
    include_once "models/question.php";
}
if (file_exists("../models/option.php")) {
    include_once "../models/option.php";
} else if (file_exists("models/option.php")) {
    include_once "models/option.php";
}

function doesUserHaveRole($userID, $roleName) { /*roleName could be "ADMIN","USERMANAGE","STUDENT"*/
    $connection = mysqli_connect("localhost", "php", "password");
    // To protect MySQL injection for Security purpose
    if (!$connection) {
        //error connecting
    } else { //connection was good
        $db = mysqli_select_db($connection,"DB_PHP");
        // SQL query to fetch information of users and finds user match.
        $queryString = "SELECT RoleID FROM ROLES WHERE RoleName = '$roleName';";
        $qCheckRoleExists= mysqli_query($connection,$queryString);

        //make sure query ran and that we got a result
        if ((is_bool($qCheckRoleExists) && !$qCheckRoleExists) || (!is_bool($qCheckRoleExists) && mysqli_num_rows($qCheckRoleExists) != 1)) {
            return false;
        }

        $roleID = $qCheckRoleExists->fetch_object()->RoleID;
        $queryString = "SELECT * FROM USER_ROLES WHERE RoleID = '$roleID' AND UserID = '$userID';";
        $qCheckRole= mysqli_query($connection,$queryString);

        if (!is_bool($qCheckRole) && mysqli_num_rows($qCheckRole) == 1) {
            return true;
        } else {
            return false;
        }

        mysqli_close($connection); // Closing Connection
    }
}

function redirect($url) {
    header("Location:$url");
    exit();
}

function getDateTimeDisplay($date) {
    if ($date == '1970-01-01 00:00:00') {
        return 'Never';
    } else {
        return $date;
    }
}

//looks for ajax call with a parameter of "action"
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'removeUserFromRole' : {
                if (!isset($_POST['User_RoleID']) || empty($_POST['User_RoleID'])) { return false; }
                echo removeUserFromRole($_POST['User_RoleID']);
                break;
                }
        case 'addUserToRole' : {
                if (!isset($_POST['UserID']) || empty($_POST['UserID'])) { return false; }
                if (!isset($_POST['RoleID']) || empty($_POST['RoleID'])) { return false; }
                echo addUserToRole($_POST['UserID'],$_POST['RoleID']);
                break;
                }
        case 'addQuestionToQuiz' : {
                if (!isset($_POST['QuizID']) || empty($_POST['QuizID'])) { return false; }
                if (!isset($_POST['Text']) || empty($_POST['Text'])) { return false; }
                if (!isset($_POST['Type']) || empty($_POST['Type'])) { return false; }
                if (!isset($_POST['IsActive'])) { return false; }
                echo addQuestionToQuiz($_POST['QuizID'],$_POST['Text'],$_POST['Type'],$_POST['IsActive']);
                break;
                }
        case 'editQuestion' : {
                if (!isset($_POST['QuestionID']) || empty($_POST['QuestionID'])) { return false; }
                if (!isset($_POST['Text']) || empty($_POST['Text'])) { return false; }
                if (!isset($_POST['Type']) || empty($_POST['Type'])) { return false; }
                if (!isset($_POST['IsActive'])) { return false; }
                echo editQuestion($_POST['QuestionID'],$_POST['Text'],$_POST['Type'],$_POST['IsActive']);
                break;
                }
        case 'disableEnableQuizQuestion' : {
                if (!isset($_POST['QuestionID']) || empty($_POST['QuestionID'])) { return false; }
                if (!isset($_POST['IsActive'])) { return false; }
                echo disableEnableQuizQuestion($_POST['QuestionID'],$_POST['IsActive']);
                break;
                }
        case 'toggleIsAnswerForOption' : {
                if (!isset($_POST['OptionID']) || empty($_POST['OptionID'])) { return false; }
                echo toggleIsAnswerForOption($_POST['OptionID']);
                break;
                }
        case 'deleteOption' : {
                if (!isset($_POST['OptionID']) || empty($_POST['OptionID'])) { return false; }
                echo deleteOption($_POST['OptionID']);
                break;
                }
        case 'addOption' : {
                if (!isset($_POST['QuestionID']) || empty($_POST['QuestionID'])) { return false; }
                if (!isset($_POST['Text']) || empty($_POST['Text'])) { return false; }
                echo addOption($_POST['QuestionID'],$_POST['Text']);
                break;
                }
        default: return false;
    }
}

function removeUserFromRole($user_RoleID) {
    if (!is_numeric($user_RoleID) || (is_numeric($user_RoleID) && !$user_RoleID)) {
        return false;
    }
    $connection = mysqli_connect("localhost", "php", "password");
    if (!$connection) {
        //error connecting
    } else { //connection was good
        //escape
        $db = mysqli_select_db($connection, "DB_PHP");
        $queryString = "DELETE FROM USER_ROLES
                        WHERE User_RoleID = $user_RoleID;";
        $qCreateUser_Role = mysqli_query($connection, $queryString);

        mysqli_close($connection); // Closing Connection
        return true;
    }
}

function addUserToRole($userID,$roleID) {
    if (!is_numeric($userID) || (is_numeric($userID) && !$userID)) {
        return false;
    }
    if (!is_numeric($roleID) || (is_numeric($roleID) && !$roleID)) {
        return false;
    }
    $connection = mysqli_connect("localhost", "php", "password");
    if (!$connection) {
        //error connecting
    } else { //connection was good
        //escape
        $db = mysqli_select_db($connection, "DB_PHP");
        $queryString = "INSERT INTO USER_ROLES(RoleID,UserID)
                        VALUES (
                            $roleID
                            ,$userID
                        );
                        ";
        $qCreateUser_Role = mysqli_query($connection, $queryString);
        $User_RoleID = $connection->insert_id;


        mysqli_close($connection); // Closing Connection
        return $User_RoleID;
    }
}


function addQuestionToQuiz($QuizID,$Text,$Type,$IsActive) {
    if (!is_numeric($QuizID) || (is_numeric($QuizID) && !$QuizID)) {
        return false;
    }
    if (!strlen($Text)) {
        return false;
    }
    if (!strlen($Type)) {
        return false;
    }
    if ($IsActive != 0 && $IsActive != 1) { //must be 0 or 1
        return false;
    }

    $quizQues = new question();

    $quizQues->QuizID = $QuizID;
    $quizQues->Text = $Text;
    $quizQues->Type = $Type;
    $quizQues->IsActive = $IsActive;
    $quizQues->save();

    if ($quizQues->QuestionID == 0) {
        return false;
    } else {
        return $quizQues->QuestionID;
    }
}

function editQuestion($QuestionID,$Text,$Type,$IsActive) {
    if (!is_numeric($QuestionID) || (is_numeric($QuestionID) && !$QuestionID)) {
        return false;
    }
    if (!strlen($Text)) {
        return false;
    }
    if (!strlen($Type)) {
        return false;
    }
    if ($IsActive != 0 && $IsActive != 1) { //must be 0 or 1
        return false;
    }

    $quizQues = (new question())->load($QuestionID);

    $quizQues->Text = $Text;
    $quizQues->Type = $Type;
    $quizQues->IsActive = $IsActive;

    $quizQues->save();

    if ($quizQues->QuestionID == 0) {
        return false;
    } else {
        return $quizQues->QuestionID;
    }
}

function disableEnableQuizQuestion($QuestionID,$IsActive) {
    if (!is_numeric($QuestionID) || (is_numeric($QuestionID) && !$QuestionID)) {
        return false;
    }
    if ($IsActive != 0 && $IsActive != 1) { //must be 0 or 1
        return false;
    }

    $quizQues = (new question())->load($QuestionID);

    $quizQues->IsActive = $IsActive;

    $quizQues->save();

    return $quizQues->IsActive;
}

function toggleIsAnswerForOption($OptionID) {
    if (!is_numeric($OptionID) || (is_numeric($OptionID) && !$OptionID)) {
        return false;
    }

    $quizQuesOpt = (new option())->load($OptionID);

    $quizQuesOpt->IsAnswer = 1-$quizQuesOpt->IsAnswer; //if 1, 1-1 is 0. if 0, 1-1 is 1. good for toggle

    $quizQuesOpt->save(); //save our new state

    return $quizQuesOpt->IsAnswer;
}

function deleteOption($OptionID) {
    if (!is_numeric($OptionID) || (is_numeric($OptionID) && !$OptionID)) {
        return false;
    }

    $quizQuesOpt = (new option())->load($OptionID);

    $result = $quizQuesOpt->delete(); //try to delete

    return $result==true;
}

function addOption($QuestionID,$Text) {
    if (!is_numeric($QuestionID) || (is_numeric($QuestionID) && !$QuestionID)) {
        return false;
    }
    if (!strlen($Text)) {
        return false;
    }

    $quizQuesOpt = (new option());

    $quizQuesOpt->QuestionID = $QuestionID;
    $quizQuesOpt->Text = $Text;

    $quizQuesOpt->save(); //try to delete

    return $quizQuesOpt->OptionID;
}


