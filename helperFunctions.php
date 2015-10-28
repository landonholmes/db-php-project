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

