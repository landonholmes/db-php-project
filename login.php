<?php
    $error=''; // var for error message
    $username=''; // Variable To Store username
    include "PasswordHash.php";

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($_POST['username']) || empty($_POST['password'])) { //check if they didn't fill it out
            $error = "Username or Password is invalid";
        } else { //okay they filled it out
            $connection = mysqli_connect("localhost", "php", "password");
            // To protect MySQL injection for Security purpose
            if (!$connection) {
                $error = "Database connection failed";
            } else { //connection was good
                $username = stripslashes($username);
                $password = stripslashes($password);
                $username = mysqli_real_escape_string($connection,$username);
                $password = mysqli_real_escape_string($connection,$password);
                // Selecting Database
                $db = mysqli_select_db($connection,"db_php");
                // SQL query to fetch information of users and finds user match.
                $qCheckLogin= mysqli_query($connection,"SELECT UserID,Password FROM USERS WHERE Username='$username';");
                if (!is_bool($qCheckLogin) && mysqli_num_rows($qCheckLogin) == 1) {
                    $qCheckLoginObj = $qCheckLogin->fetch_object();
                    if (validate_password($password, $qCheckLoginObj->Password)) {
                        $_SESSION['loggedIn'] = true;
                        $_SESSION['loggedInUserID'] = $qCheckLoginObj->UserID;

                        if (doesUserHaveRole($_SESSION['loggedInUserID'],"TEACH") ) {
                            header("location: index.php?action=manageQuiz"); // redirect to other page
                        }
                        if (doesUserHaveRole($_SESSION['loggedInUserID'],"USERMANAGE") ) {
                            header("location: index.php?action=manageUsers"); // redirect to other page
                        }
                        if (doesUserHaveRole($_SESSION['loggedInUserID'],"STUDENT") ) {
                            header("location: index.php?action=quiz"); // redirect to other page
                        }

                    }
                } else {
                    $error = "Username or Password is invalid";
                }

                mysqli_close($connection); // Closing Connection
            }
        }
    }
?>

<br />
<div  style="text-align: center;">
    <div class="col-sm-4 col-sm-offset-4"  style="margin-top: 3%;">
        <form class="form-inline" method="POST" action="index.php?action=login">
            <fieldset>
                <div class="panel panel-primary" >
                    <legend class="panel-heading panel-title">Log In</legend>
                    <div class="panel-body">
                        <div class="form-group <?php if (strlen($error)) {echo 'has-error';} ?>" >
                            <div class="controls input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                                <input type="text" id="username" name="username" class="input form-control" placeholder="Username" value="<?php echo $username;?>" />
                            </div>
                        </div><br /><br />
                        <div class="form-group <?php if (strlen($error)) {echo 'has-error';} ?>"">
                            <div class="controls input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                                <input type="password" id="password" name="password" class="input form-control" placeholder="Password" value="" />
                            </div>
                        </div><br />
                        <?php if (strlen($error)) {echo '<div class="form-group has-error"><span><br />'.$error.'</span></div><br />';} ?>
                        <br />
                        <div class="form-group">
                            <div class="controls">
                                <input type="submit" name="submit" class="btn btn-default" value="Login" />
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

</div>
<script src="./assets/js/jquery.min.js"></script>
<script src="./assets/js/bootstrap.min.js"></script>

<script>
<?php
    if (strlen($username)) {
        echo "$('#password').focus();";
    } else {
        echo "$('#username').focus();";
    }
?>
</script>
