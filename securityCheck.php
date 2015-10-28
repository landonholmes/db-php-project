<?php
if(!isset($_SESSION['loggedIn']) || (isset($_SESSION['loggedIn']) && !$_SESSION['loggedIn'])) {
    redirect("index.php?action=login"); // Redirecting To Home Page
}
