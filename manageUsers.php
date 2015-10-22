<?php
session_start();

if(!isset($_SESSION['loggedIn'])) {
    header("Location: login.php"); // Redirecting To Home Page
    exit;
}
?>
<html>
    <head>
        <title>Manage Users</title>
        <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon">
    </head>
    <body>
        <div class="container">
            <br /><a href="index.php" style="float:right; margin-top: 40px;">Back</a>
            <h1>Managing Users</h1>
            <div class="row">
                <div class="col-md-4">
                    Nothing.
                </div>
            </div>
        </div>
        <script src="./assets/js/jquery.min.js"></script>
        <script src="./assets/js/bootstrap.min.js"></script>
    </body>
</html>