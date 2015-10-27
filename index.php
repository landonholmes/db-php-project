<?php
//this file acts as a controller, including pages that are necessary
if (!isset($_GET["action"])) {
    include 'manage.php';
} else {
    switch($_GET["action"]) {
        case "login": include 'login.php'; break;
        case "manageUsers": include 'manageUsers.php'; break;
        default: include 'manage.php';
    }
}
