<?php
if(!isset($_SESSION['loggedIn']) || (isset($_SESSION['loggedIn']) && !$_SESSION['loggedIn'])) {
    header("Location: index.php?action=login"); // Redirecting To Home Page
    exit;
}
