<?php
    session_start(); // Starting Session
    $error=''; // var for error message
    $username=''; // Variable To Store username
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];

        if (empty($_POST['username']) || empty($_POST['password'])) { //check if they didn't fill it out
            $error = "Username or Password is invalid";
        } else { //okay they filled it out
            if ($_POST['username'] != 'landon' && $_POST['password'] != 'notpassword') { //validate
                $error = "Username or Password is invalid";
            } else { //hey they're right
                $_SESSION['loggedIn']=true;
                header("location: manageUsers.php"); // redirect to other page
            }
        }
    }
?>
<html>
    <head>
        <title>Login</title>
        <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon">
    </head>
    <body>
        <div class="container">
            <br />
            <div  style="text-align: center;">
                <div class="col-sm-4 col-sm-offset-4"  style="margin-top: 3%;">
                    <form class="form-inline" method="POST" action="login.php">
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
    </body>
</html>