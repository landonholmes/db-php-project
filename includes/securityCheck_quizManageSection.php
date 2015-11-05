<?php
//i am including the regular security check first so we can assume user is logged in
if(!$_SESSION['loggedInUser']->isUserInRole("TEACH")) {
    redirect("index.php?action=login"); // Redirecting To Home Page
}
