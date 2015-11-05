<?php
//i am including the regular security check first so we can assume user is logged in
if(!$_SESSION['loggedInUser']->isUserInRole("USERMANAGE") && !$_SESSION['loggedInUser']->isUserInRole("TEACH")) { //both teachers and user management users can access user management
    redirect("index.php?action=login"); // Redirecting To Home Page
}
