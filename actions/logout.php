<?php
    $_SESSION['loggedIn']=false;
    $_SESSION['loggedInUserID']=0;
    redirect("index.php?action=login"); // redirect to other page

