<?php

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

