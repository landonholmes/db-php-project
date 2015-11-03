<nav class="navbar navbar-default navbar-static-top navbar-inverse" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php?action=login">Quizzeret</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?php
            if(doesUserHaveRole($_SESSION['loggedInUserID'],"TEACH") || doesUserHaveRole($_SESSION['loggedInUserID'],"STUDENT") ) { //if a user is in a group
                echo "
                    <ul class=\"nav navbar-nav navbar-left\">
                        <li";
                if ($activeNavTab == "quizList") {echo " class=\"active\"";}
                echo "><a href=\"index.php?action=quizList\"><i class=\"glyphicon glyphicon-list-alt\"></i>&nbsp;Take Quiz</a></li>
                    <li";
                if ($activeNavTab == "quizResults") {echo " class=\"active\"";}
                echo "><a href=\"index.php?action=quizResults\"><i class=\"glyphicon glyphicon-stats\"></i>&nbsp;Results</a></li>
                    </ul>
                ";
            }
            ?>

            <ul class="nav navbar-nav navbar-right">
                <?php
                if(doesUserHaveRole($_SESSION['loggedInUserID'],"TEACH")) { //if a user is in a group
                    echo "<li";
                    if ($activeNavTab == "manageQuiz") {echo " class=\"active\"";}
                    echo "><a href='index.php?action=manageQuiz'><i class='glyphicon glyphicon-th-list'></i>&nbsp;Quiz Management</a></li>";
                    echo "<li";
                    if ($activeNavTab == "userResults") {echo " class=\"active\"";}
                    echo "><a href='index.php?action=userResults'><i class='glyphicon glyphicon-stats'></i>&nbsp;User Results</a></li>";
                }
                if(doesUserHaveRole($_SESSION['loggedInUserID'],"TEACH") || doesUserHaveRole($_SESSION['loggedInUserID'],"USERMANAGE")) { //if a user is in a group
                    echo "<li";
                    if ($activeNavTab == "userManage") {echo " class=\"active\"";}
                    echo "><a href='index.php?action=manageUsers'><i class='glyphicon glyphicon-cog'></i>&nbsp;User Management</a></li>";
                }

                if ($_SESSION['loggedIn']) {
                    echo "
                        <li class=\"dropdown\">
                            <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                                <i class=\"glyphicon glyphicon-user glyphicon-white\"></i>&nbsp;".(new user())->load($_SESSION['loggedInUserID'])->Username."<b class=\"caret\"></b>
                            </a>
                            <ul id=\"actions-submenu\" class=\"dropdown-menu\">";
                                /*<li><a href=\"index.php?action=userDetail&userID=".$_SESSION['loggedInUserID']."\">Account Settings</a></li>*/
                                echo "<li><a href=\"index.php?action=logout\">Logout</a></li>
                            </ul>
                        </li>
                    ";
                } else {
                    echo "<li><a href=\"index.php?action=login\">Login</a></li>";
                }
                ?>
            </ul>
        </div><!--- /.navbar-collapse --->
    </div>
</nav>