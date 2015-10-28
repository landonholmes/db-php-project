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
        <?php
            echo "
            <div class=\"col-sm-8\">
                <h2>$user->FirstName $user->LastName</h2>

                <table class=\"table table-condensed table-detail\">
                    <tr>
                        <th width=\"200\">
                            Email:
                        </th>
                        <td>
                            $user->Email
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Username:
                        </th>
                        <td>
                            $user->Username &nbsp;";
                            if ($user->IsLocked == 1) {
                                echo "<span class=\"label label-warning\">Locked</span>";
                            } else {
                                echo "<span class=\"label label-info\">Active</span>";
                            }
                 echo "
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Name:
                        </th>
                        <td>
                            $user->FirstName $user->LastName
                        </td>
                    </tr>
                    <tr>
                    <th>
                        Created:
                    </th>
                    <td>
                        $user->CreatedOn
                    </td>
                    <tr>
                        <th>
                            Last Modified:
                        </th>
                        <td>
                            $user->LastModifiedOn
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Password Last Set:
                        </th>
                        <td>
                            $user->PasswordLastSetOn
                        </td>
                    </tr>

                    <tr>
                        <th>
                            Last Login:
                        </th>
                        <td>
                            $user->LastLoggedInOn
                        </td>
                    </tr>
                </table>
            </div>
            <div class=\"col-sm-4\"><br />
            <div class=\"well\">";

            if ($_SESSION['loggedInUserID'] == $user->UserID) {
              echo "<p>To update your account, click the button below.</p>
					<a href=\"index.php?action=userForm&userID=$userID\" class=\"btn btn-default\">Update Account</a>";
            } else{
                echo "<p>To update this user, click the button below.</p>
					<a href=\"index.php?action=userForm&userID=$userID\" class=\"btn btn-default\">Update User</a>";
            }
            echo "</div>
                </div>";
        ?>
    </div>
</div>
