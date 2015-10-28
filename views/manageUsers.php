<?php
include "models/user.php";
$connection = mysqli_connect("localhost", "php", "password");
if (!$connection) {
    //error connecting
} else { //connection was good
    $db = mysqli_select_db($connection, "DB_PHP");
    $queryString = "SELECT * FROM USERS;";
    $getUsers = mysqli_query($connection, $queryString);
    $getUsers->fetch_all();
    $userList = array();
    foreach ($getUsers as $userThing) {
        array_push($userList,(new user())->populateFromQuery($userThing));
    }
}
d($getUsers);
d($userList);
mysqli_close($connection); // Closing Connection
?>

<div class="row">
    <h1>Managing Users</h1>
    <div class="col-md-12">
        <?php if(count($getUsers) < 1) {
            echo 'No users found..';
        } else {
            echo "
                <table class=\"table table-condensed table-bordered\">
                    <thead>
                        <tr>
                            <th style=\"width:225px;\">
                                Username
                            </th>
                            <th>
                                Email
                            </th>
                            <th style=\"width:250px;\">
                                Name
                            </th>
                            <th style=\"width:50px;\">
                                &nbsp;<!--active-->
                            </th>
                            <th style=\"width:200px;\">
                                Password Last Set
                            </th>
                            <th style=\"width:150px;\">
                                Last Login
                            </th>
                        </tr>
                    </thead>
                    <tbody>";

            foreach ($userList as $singleUser) {
                echo "<tr>
                        <td>
                            <a href=\"index.php?action=userDetail&userID=$singleUser->UserID\">$singleUser->Username</a>
                        </td>
                        <td>
                            <a href=\"index.php?action=userDetail&userID=$singleUser->UserID\">$singleUser->Email</a>
                        </td>
                        <td>
                            $singleUser->FirstName $singleUser->LastName
                        </td>
                        <td style=\"text-align:center;\">
                        ";

                if ($singleUser->IsLocked == 1) {
                    echo "<span class=\"label label-warning\">Locked</span>";
                } else {
                    echo "<span class=\"label label-info\">Active</span>";
                }

                echo "<td>
                            $singleUser->PasswordLastSetOn
                        </td>
                        <td>
                            $singleUser->LastLoggedInOn
                        </td>
                    </tr>
                ";
            }

            echo "</tbody>
                </table>
            ";
        }

        ?>
    </div>
</div>
