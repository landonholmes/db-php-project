<?php
if(!isset($_SESSION)) {session_start();} //checking if session needs to be started
//this file acts as a controller, including pages that are necessary
if (!isset($_GET["action"])) {
    $toInclude = 'login.php';
    $pageTitle='Log In';
    $securedPage=false;
} else {
    $securedPage=true; //pages are security checked by default and explicity stated if not
    switch($_GET["action"]) {
        case "login": $toInclude = 'login.php'; $pageTitle='Log In'; $securedPage=false; break;
        case "logout": $toInclude = 'logout.php';  $pageTitle='Log Out' ; $securedPage=false ;break;
        case "manageUsers": $toInclude = 'manageUsers.php'; $pageTitle='Manage Users'; break;
        default: $toInclude = 'login.php'; $pageTitle='Log In';
    }
}

if ($securedPage) {
    include "securityCheck.php";
}
include "helperFunctions.php";

?>

<html>
    <head>
        <title><?php echo $pageTitle; ?></title>
        <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="./assets/css/main.css" rel="stylesheet">
        <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon">
    </head>
    <body>
        <?php include "navbar.php"; ?>
        <div class="container">
            <?php include $toInclude; ?>
        </div>
        <script src="./assets/js/jquery.min.js"></script>
        <script src="./assets/js/bootstrap.min.js"></script>
    </body>
</html>