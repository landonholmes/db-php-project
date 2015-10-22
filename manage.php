<?php
session_start();

if(!isset($_SESSION['loggedIn']) || (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == false)) {
    header("Location: login.php"); // Redirecting To Login Page
    exit;
} else {
    header("Location: manageUsers.php"); // Redirecting To Home Page
    exit;
}
