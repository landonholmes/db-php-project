<?php
include_once "includes/PasswordHash.php";
if (isset($_POST['submit']) && isset($_POST['userID'])) {
    //param'ing for userID
    if (is_numeric($_POST['userID'])) {
        $userID = $_POST['userID'];
    } else {
        $userID = 0; //default to 0
    }

    //param'ing for remote address
    if ($_SERVER['REMOTE_ADDR'] == "::1") {
        $ip = "0.0.0.0";
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }


    $user = (new user())->load($userID); //load a model
    $rightNow = date("Y-m-d H:i:s");

    $user->Username = $_POST['username'];
    $user->Email = $_POST['email'];
    $user->FirstName = $_POST['firstName'];
    $user->LastName = $_POST['lastName'];

    if (isset($_POST['changePasswords']) && ($_POST['changePasswords'] == "true") && strlen($_POST['password'])) {
        $user->Password = create_hash($_POST['password']);
        $user->PasswordLastSetOn = $rightNow;
        $user->PasswordLastSetBy = $_SESSION['loggedInUser']->UserID;
        $user->PasswordLastSetByIP = $ip;
    }

    $user->IsLocked = $_POST['isLocked'];

    if ($userID == 0) {
        $user->CreatedOn = $rightNow;
        $user->CreatedBy = $_SESSION['loggedInUser']->UserID;
        $user->CreatedByIP = $ip;
    }

    $user->LastModifiedOn = $rightNow;
    $user->LastModifiedBy = $_SESSION['loggedInUser']->UserID;
    $user->LastModifiedByIP = $ip;

    $user = $user->save();
    redirect("$root/index.php?action=userDetail&userID=$user->UserID");
} else {
    redirect("$root/index.php?action=manageUsers");
}





