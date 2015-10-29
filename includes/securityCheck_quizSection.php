<?php
//i am including the regular security check first so we can assume user is logged in
if(!doesUserHaveRole($_SESSION['loggedInUserID'],"TEACH") && !doesUserHaveRole($_SESSION['loggedInUserID'],"STUDENT")) {
    redirect("index.php?action=login"); // Redirecting To Home Page
}
