<?php
include "models/user.php";
if (isset($_GET["userID"])) {
    $userID = $_GET["userID"];
} else {
    //we didn't get an id. abort
    redirect("$root/index.php?action=manageUsers");
}
$connection = mysqli_connect("localhost", "php", "password");
if (!$connection) {
    //error connecting
} else { //connection was good
    $db = mysqli_select_db($connection, "DB_PHP");
    $queryString = "SELECT * FROM USERS WHERE UserID = '$userID';";
    $getUser = mysqli_query($connection, $queryString);
    $getUser = $getUser->fetch_array();
    $user = (new user())->populateFromQuery($getUser);
}

mysqli_close($connection); // Closing Connection
?>
<div class="row">
    <div class="col-md-12">
        <h2>User Form</h2>
    </div>
</div>

<div class="row">
    <form class="form-horizontal" action="index.php?action=actUserFormSubmit" method="POST">
        <div id="username-form-group" class="form-group">
            <label class="control-label col-md-2 label-required" for="username">Username:</label>
            <div class="col-md-5">
                <input type="text" id="username" name="username" class="form-control" value="<?php print $user->Username;?>" />
            </div>
            <div>
                <!--error message?-->
                <span class="help-block" id="username_loading" style="display:none;"><img src="assets/img/ajax-loader.gif" /></span>
                <span class="help-block" id="username_ok" style="display:none;"><span class="glyphicon glyphicon-ok"></span></span>
                <span class="help-block" id="username_warning" style="display:none;"><i class="glyphicon glyphicon-warning-sign"></i> That username is already assigned.</span>
                <span class="help-block" id="username_invalid" style="display:none;"><i class="glyphicon glyphicon-warning-sign"></i> Please enter a username.</span>
            </div>
        </div>

        <div id="email-form-group" class="form-group">
            <label class="control-label col-md-2" for="email">Email:</label>
            <div class="col-md-5">
                <input type="text" id="email" name="email" class="form-control" value="<?php print $user->Email;?>" />
            </div>
            <div>
                <!--error message?-->
                <span class="help-block" id="email_loading" style="display:none;"><img src="assets/img/ajax-loader.gif" /></span>
                <span class="help-block" id="email_ok" style="display:none;"><span class="glyphicon glyphicon-ok"></span></span>
                <span class="help-block" id="email_warning" style="display:none;"><i class="glyphicon glyphicon-warning-sign"></i> That email address is already assigned.</span>
                <span class="help-block" id="email_invalid" style="display:none;"><i class="glyphicon glyphicon-warning-sign"></i> Email address is not valid.</span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2 label-required" for="firstName">First Name:</label>
            <div class="col-md-5">
                <input type="text" id="firstName" name="firstName" class="form-control" value="<?php print $user->FirstName;?>" />
                <!--error message?-->
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2 label-required" for="lastName">Last Name:</label>
            <div class="col-md-5">
                <input type="text" id="lastName" name="lastName" class="form-control" value="<?php print $user->LastName;?>" />
                <!--error message?-->
            </div>
        </div>

        <div class="well" id="passwordQuestionsWell">
            <div class="checkbox" style="margin-bottom: 7px;">
                <label class="control-label col-md-2"></label>
                <div class="col-md-5">
                    <input type="checkbox" name="changePasswords" value="true" />
                    <label for="showPasswordText">Change Password? (if not, ignore this block)</label>
                </div>
            </div>
            <div class="checkbox" style="margin-bottom: 7px;">
                <label class="control-label col-md-2"></label>
                <div class="col-md-5">
                    <input type="checkbox" id="showPasswordText" value="true" />
                    <label for="showPasswordText">Show Passwords</label>
                </div>
            </div>

            <div class="form-group passwordInputFormGroup">
                <label class="control-label col-md-2 label-required" for="password">Password:</label>
                <div class="col-md-5">
                    <input type="password" id="password" name="password" class="form-control passwordInput" value="" />
                    <!--error message?-->
                    <span class="help-block passwordsDontMatchErrorMessage" style="display:none;">The passwords do not match. Please try again.</span>
                </div>
            </div>
            <div class="form-group passwordInputFormGroup">
                <label class="control-label col-md-2 label-required" for="password2">Password Again:</label>
                <div class="col-md-5">
                    <input type="password" id="password2" name="password2" class="form-control passwordInput" value="" />
                    <!--error message?-->
                    <span class="help-block passwordsDontMatchErrorMessage" style="display:none;">The passwords do not match. Please try again.</span>
                </div>
            </div>
        </div>
        <div class="col-md-offset-1 col-md-6 well">
            <input type="hidden" name="lastModifiedBy" value="<?php print $_SESSION['loggedInUserID'];?>" />
            <input type="hidden" name="userID" value="<?php print $user->UserID;?>" />
            <input type="submit" value="Submit" name="submit" class="btn btn-primary" id="accountSubmitButton" />
        </div>
    </form>

    <script>
        var PAGE = {
            userID: <?php print $user->UserID;?>,
            xeh: {
                ajaxIsUsernameAvailable: '',
            };
    </script>
</div>
