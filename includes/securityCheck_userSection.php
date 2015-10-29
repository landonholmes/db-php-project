<?php
//i am including the regular security check first so we can assume user is logged in
if(!doesUserHaveRole($_SESSION['loggedInUserID'],"USERMANAGE") && !doesUserHaveRole($_SESSION['loggedInUserID'],"TEACH")) { //both teachers and user management users can access user management
    redirect("index.php?action=login"); // Redirecting To Home Page
}
