<?php
session_start();

if(!isset($_SESSION['loggedIn']) || (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == false)) {
    header("Location: index.php?action=login");// Redirecting To Login Page
} else {
    header("Location: index.php?action=manageUsers"); // Redirecting To Home Page
}
