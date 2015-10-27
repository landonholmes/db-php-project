<?php
    $_SESSION['loggedIn']=false;
    $_SESSION['loggedInUserID']=0;
    header("location: index.php?action=login"); // redirect to other page

