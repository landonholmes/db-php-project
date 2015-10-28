<?php
if(!isset($_SESSION)) {session_start();} //checking if session needs to be started
$root = $_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
//this file acts as a controller, including pages that are necessary
if (!isset($_GET["action"])) {
    $toInclude = './views/login.php';
    $pageTitle='Log In';
    $securedPage=false;
} else {
    $securedPage=true; //pages are security (loggedIn = true) checked by default and explicitly stated if not
    switch($_GET["action"]) {
        case "login": $toInclude = './views/login.php'; $pageTitle='Log In'; $securedPage=false; break;
        case "logout": $toInclude = 'logout.php';  $pageTitle='Log Out' ; $securedPage=false ;break;
        case "manageUsers": $toInclude = './views/manageUsers.php'; $pageTitle='Manage Users'; break;
        case "userDetail": $toInclude = './views/userDetail.php'; $pageTitle='User Detail'; break;
        case "userForm": $toInclude = './views/userForm.php'; $pageTitle='User Form'; break;
        case "actUserFormSubmit": $toInclude = './actions/actUserFormSubmit.php'; $pageTitle='User Form'; break;
        default: $toInclude = './views/login.php'; $pageTitle='Log In';
    }
}

if ($securedPage) {
    include "securityCheck.php";
}
include "helperFunctions.php";
require './assets/kint/Kint.class.php';

?>

<html>
    <head>
        <title><?php echo $pageTitle; ?></title>
        <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="./assets/css/main.css" rel="stylesheet">
        <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon">
        <script src="./assets/js/jquery.min.js"></script>
        <script src="./assets/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php include "navbar.php"; ?>
        <div class="container">
            <?php include $toInclude; ?>
        </div>
    </body>
</html>