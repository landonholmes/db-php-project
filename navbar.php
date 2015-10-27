<nav class="navbar navbar-default navbar-static-top navbar-inverse" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Quizzeret</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?php
            if(doesUserHaveRole($_SESSION['loggedInUserID'],"TEACH") || doesUserHaveRole($_SESSION['loggedInUserID'],"STUDENT") ) { //if a user is in a group
                echo "
                    <ul class=\"nav navbar-nav navbar-left\">
                        <li><a href=\"index.php?action=quiz\"><i class=\"fa fa-lg fa-th-large\"></i> Quiz</a></li>
                    </ul>
                ";
            }
            ?>

            <ul class="nav navbar-nav navbar-right">
                <?php
                if(doesUserHaveRole($_SESSION['loggedInUserID'],"TEACH") || doesUserHaveRole($_SESSION['loggedInUserID'],"USERMANAGE")) { //if a user is in a group
                    echo "<li><a href='index.php?action=manageUsers'><i class='fa fa-lg fa-users'></i>&nbsp;User Management</a></li>";
                }

                if ($_SESSION['loggedIn']) {
                    echo "
                        <li class=\"dropdown\">
                            <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                                <i class=\"icon-user icon-white\"></i>User <b class=\"caret\"></b>
                            </a>
                            <ul id=\"actions-submenu\" class=\"dropdown-menu\">
                                <li><a href=\"index.php?action=account\">Account Settings</a></li>
                                <li><a href=\"index.php?action=logout\">Logout</a></li>
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