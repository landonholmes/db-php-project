<?php
include "models/user.php";
$connection = mysqli_connect("localhost", "php", "password");
if (!$connection) {
    //error connecting
} else { //connection was good
    $db = mysqli_select_db($connection, "DB_PHP");
    $queryString = "SELECT * FROM USERS;";
    $getUsers = mysqli_query($connection, $queryString);
    Kint::dump($getUsers->fetch_all());
}

mysqli_close($connection); // Closing Connection
?>

<div class="row">
    <h1>Managing Users</h1>
    <div class="col-md-4">
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
                            <th style=\"width:150px;\">
                                Password Last Set
                            </th>
                            <th style=\"width:150px;\">
                                Last Login
                            </th>
                        </tr>
                    </thead>
                    <tbody>";
            /*loop*/

            echo "</tbody>
                </table>
            ";
        }

        ?>
    </div>
</div>
