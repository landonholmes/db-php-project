<?php
    $_SESSION['loggedIn']=false;
    $_SESSION['loggedInUser']=(new user());
    redirect("index.php?action=login"); // redirect to other page

