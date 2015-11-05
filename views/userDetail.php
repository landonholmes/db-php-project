<?php
if (isset($_GET["userID"]) && is_numeric($_GET["userID"])) {
    $userID = $_GET["userID"];
} else {
    //we didn't get an id. abort
    redirect("$root/index.php?action=manageUsers");
}

$user = (new user())->load($userID);
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
                            ".getDateTimeDisplay($user->LastLoggedInOn)."
                        </td>
                    </tr>
                </table>
            </div>
            <div class=\"col-sm-4\"><br />";

        echo "<div class=\"well\">";
        if ($user->UserID == $_SESSION['loggedInUser']->UserID) {
            echo "<strong>Your Roles</strong>";
        } else {
            echo "<strong>$user->FirstName $user->LastName's Roles</strong>";
        }
        $userRoles = $user->getRoles();
        $availableRoles = $user->getAllAvailableRoles();
        echo "<br />
                <ul id=\"roleUL\">";
        foreach ($userRoles as $role) {
            echo "<li class=\"userRoleItem list-role-item\" data-user-id=\"$user->UserID\" data-role-id=\"$role->RoleID\" data-role-user-id=\"$role->User_RoleID\">$role->RoleName";
             if ($user->UserID != $_SESSION['loggedInUser']->UserID) {echo "<i style=\"float:right;\" class=\"glyphicon glyphicon-remove icon-white\"></i>"; }
            echo"</li>";
        }
        echo "</ul>";
        if ( ($user->UserID != $_SESSION['loggedInUser']->UserID) && ($_SESSION['loggedInUser']->isUserInRole("TEACH") || $_SESSION['loggedInUser']->isUserInRole("USERMANAGE"))) {
            echo "<select id=\"newRoleID\" class=\"addRoleSelect form-control\" >
		                <option value=\"-1\" data-user-id=\"-1\" data-role-id=\"-1\" disabled=\"true\" selected=\"true\">- Choose Role -</option>";
                foreach ($availableRoles as $availRole) {
                    echo "<option class=\"newRoleOption\" value=\"$availRole->RoleID\" data-user-id=\"$user->UserID\" data-role-id=\"$availRole->RoleID\">$availRole->RoleName</option>";
                }
		    echo "</select>";
        }
        echo "</div><div class=\"well\"";

            if ($_SESSION['loggedInUser']->UserID == $user->UserID) {
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
<script>
    var PAGE = {arAllRoles: [  <?php $index=0; foreach($availableRoles as $availRole) {
                        if ($index>0) {echo ",";}
                        echo "{RoleID:$availRole->RoleID,RoleName:\"$availRole->RoleName\"}";
                        $index++;
                    }
                ?>
         ]
    };

    $(function(){init();});

    function init() {
        updateAddRoleDropdown();
    }

    <?php if ( ($user->UserID != $_SESSION['loggedInUser']->UserID) && ($_SESSION['loggedInUser']->isUserInRole("TEACH") || $_SESSION['loggedInUser']->isUserInRole("USERMANAGE"))) {
            echo "$(\"#roleUL\").delegate(\"li\", \"click\", function(e){
                elem = $(this);

                var user_roleID = elem.attr(\"data-role-user-id\");

                $.ajax( {
                    \"dataType\": \"json\",
                    \"type\": \"POST\",
                    \"url\": \"includes/helperFunctions.php\",
                    \"data\": {\"action\":\"removeUserFromRole\", \"User_RoleID\":user_roleID},
                    \"success\": function(e) {
                        console.log(e);
                        if(e == 1){
                            elem.remove();
                            updateAddRoleDropdown();
                        }
                    },
                    \"timeout\": 15000,
                    \"error\": function(e) {
                    console.log(\"errr\",e);
                        updateAddRoleDropdown();
                    }
                });

            })";
        }
    ?>

    $("#newRoleID").change(function(e){
        elem = $("#newRoleID option:selected");

        var roleID = elem.attr("data-role-id");
        var userID = elem.attr("data-user-id");
        var roleName = elem.html();

        $.ajax( {
            "dataType": 'json',
            "type": 'POST',
            "url": "includes/helperFunctions.php",
            "data": {"action":"addUserToRole","UserID":userID, "RoleID":roleID},
            "success": function(e) {
                if(e === +e){
                    var newRoleUL = '<li class="userRoleItem list-role-item" data-user-id="' + userID + '" data-role-id="' + roleID + '" data-role-user-id="' + e + '">' + roleName + '';
                    <?php if ($user->UserID != $_SESSION['loggedInUser']->UserID) {echo "newRoleUL += '<i style=\"float:right;\" class=\"glyphicon glyphicon-remove icon-white\"></i>';";}?>
                    newRoleUL += '</li>';
                    $("#roleUL").append(newRoleUL);
                    $("#newRoleID").val(-1);
                    updateAddRoleDropdown();
                }
            },
            "timeout": 15000,
            "error": function(e) {
                $("#newRoleID").val(-1);
                updateAddRoleDropdown();
            }
        });
    });


    function updateAddRoleDropdown () {
        var assignedRoles = {};
        $("#roleUL li").each(function (index, elem) {
            var roleID = $(elem).attr("data-role-id");

            assignedRoles[roleID.toString()] = true;
        });

        $(".newRoleOption").each(function (index, elem) {
            $(elem).remove();
        });

        $(PAGE.arAllRoles).each(function (index, elem) {
            if (elem.roleID in assignedRoles) {
                //do nothing
            } else {
                $("#newRoleID").append('<option class="newRoleOption" value="' + elem.RoleID + '" data-user-id="' + <?php print $user->UserID ?> + '" data-role-id="' + elem.RoleID + '">' + elem.RoleName + '</option>');
            }
        });

        $(".newRoleOption").each(function (index, elem) {
            var roleID = $(elem).attr("data-role-id");

            if (roleID in assignedRoles) {
                $(elem).remove();
            }
        });

        if ($(".newRoleOption").length === 0) {
            $("#newRoleID").hide();
        } else {
            $("#newRoleID").show();
        }
    }

</script>
