<?php
class user {
    private $_never = '1970-01-01 00:00:00';
    public $UserID = 0;
    public $Username = "";
    public $Email = "";
    public $FirstName = "";
    public $LastName = "";
    public $Password = "";
    public $PasswordLastSetOn = '1970-01-01 00:00:00';
    public $PasswordLastSetBy = 0;
    public $PasswordLastSetByIP = "";
    public $LastLoggedInOn = '1970-01-01 00:00:00';
    public $IsLocked = 0;
    public $CreatedOn = '1970-01-01 00:00:00';
    public $CreatedBy = 0;
    public $CreatedByIP = "";
    public $LastModifiedOn = '1970-01-01 00:00:00';
    public $LastModifiedBy = 0;
    public $LastModifiedByIP = "";

    public function load($userID){
        if (!$userID) {
            return $this;
        }

        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            //error connecting
        } else { //connection was good
            $userID = mysqli_real_escape_string($connection, stripslashes($userID));
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "SELECT * FROM USERS WHERE UserID='$userID';";
            $qCheckLogin = mysqli_query($connection, $queryString);

            if (!is_bool($qCheckLogin) && mysqli_num_rows($qCheckLogin) == 1) {
                $qCheckLoginObj = $qCheckLogin->fetch_object();

                $this->UserID = $qCheckLoginObj->UserID;
                $this->Username = $qCheckLoginObj->Username;
                $this->Email = $qCheckLoginObj->Email;
                $this->FirstName = $qCheckLoginObj->FirstName;
                $this->LastName = $qCheckLoginObj->LastName;
                $this->Password = $qCheckLoginObj->Password;
                $this->PasswordLastSetOn = $qCheckLoginObj->PasswordLastSetOn;
                $this->PasswordLastSetBy = $qCheckLoginObj->PasswordLastSetBy;
                $this->PasswordLastSetByIP = $qCheckLoginObj->PasswordLastSetByIP;
                $this->LastLoggedInOn = $qCheckLoginObj->LastLoggedInOn;
                $this->IsLocked = $qCheckLoginObj->IsLocked;
                $this->CreatedOn = $qCheckLoginObj->CreatedOn;
                $this->CreatedBy = $qCheckLoginObj->CreatedBy;
                $this->CreatedByIP = $qCheckLoginObj->CreatedByIP;
                $this->LastModifiedOn = $qCheckLoginObj->LastModifiedOn;
                $this->LastModifiedBy = $qCheckLoginObj->LastModifiedBy;
                $this->LastModifiedByIP = $qCheckLoginObj->LastModifiedByIP;

            } else {
                //error, return empty
            }

            mysqli_close($connection); // Closing Connection
            return $this;
        }
    }

    public function loadAll() {
        $connection = mysqli_connect("localhost", "php", "password");

        if (!$connection) {
            $errorMsg = "no connection";
        } else { //connection was good
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "SELECT * FROM USERS;";
            $getUsers = mysqli_query($connection, $queryString);
            mysqli_close($connection); // Closing Connection
            $userList = [];
            if (is_bool($getUsers) && !$getUsers) {
                $errorMsg = 'bad query';
            } else {
                $getUsers->fetch_array();
                foreach ($getUsers as $userThing) {
                    array_push($userList, (new user())->populateFromQuery($userThing));
                }
            }
        }

        return $userList;
    }

    public function save() {
        if ($this->UserID == 0) {
            return $this->create();
        } else {
            return $this->update();
        }

    }

    //assumes record does not exist in DB and intends to insert one
    public function create() {
        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            //error connecting
        } else { //connection was good
            $this->enforceSQLProtection($connection);
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "INSERT INTO USERS(Username
                                ,Email
                                ,FirstName
                                ,LastName
                                ,Password
                                ,PasswordLastSetOn
                                ,PasswordLastSetBy
                                ,PasswordLastSetByIP
                                ,LastLoggedInOn
                                ,IsLocked
                                ,CreatedOn
                                ,CreatedBy
                                ,CreatedByIP
                                ,LastModifiedOn
                                ,LastModifiedBy
                                ,LastModifiedByIP)
                            VALUES (
                                '$this->Username'
                                ,'$this->Email'
                                ,'$this->FirstName'
                                ,'$this->LastName'
                                ,'$this->Password'
                                ,'$this->PasswordLastSetOn'
                                ,'$this->PasswordLastSetBy'
                                ,'$this->PasswordLastSetByIP'
                                ,'$this->LastLoggedInOn'
                                ,'$this->IsLocked'
                                ,'$this->CreatedOn'
                                ,'$this->CreatedBy'
                                ,'$this->CreatedByIP'
                                ,'$this->LastModifiedOn'
                                ,'$this->LastModifiedBy'
                                ,'$this->LastModifiedByIP'
                            );
                            ";
            $qCreateUser = mysqli_query($connection, $queryString);
            $this->UserID = $connection->insert_id;


            mysqli_close($connection); // Closing Connection
            return $this;
        }
    }

    //assumes record does exist in DB and intends to update that one
    public function update() {
        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            //error connecting
        } else { //connection was good
            $this->enforceSQLProtection($connection);
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "UPDATE USERS
                            SET Username = '$this->Username'
                                ,Email = '$this->Email'
                                ,FirstName = '$this->FirstName'
                                ,LastName = '$this->LastName'
                                ,Password = '$this->Password'
                                ,PasswordLastSetOn = '$this->PasswordLastSetOn'
                                ,PasswordLastSetBy = '$this->PasswordLastSetBy'
                                ,PasswordLastSetByIP = '$this->PasswordLastSetByIP'
                                ,LastLoggedInOn = '$this->LastLoggedInOn'
                                ,IsLocked = '$this->IsLocked'
                                ,CreatedOn = '$this->CreatedOn'
                                ,CreatedBy = '$this->CreatedBy'
                                ,CreatedByIP = '$this->CreatedByIP'
                                ,LastModifiedOn = '$this->LastModifiedOn'
                                ,LastModifiedBy = '$this->LastModifiedBy'
                                ,LastModifiedByIP = '$this->LastModifiedByIP'
                                WHERE  UserID = '$this->UserID';
                            ";
            $qUpdateUser = mysqli_query($connection, $queryString);

            mysqli_close($connection); // Closing Connection
            return $this;
        }
    }

    private function enforceSQLProtection($conn) {
        $this->UserID = mysqli_real_escape_string($conn,$this->UserID);
        $this->Username = mysqli_real_escape_string($conn,$this->Username);
        $this->Email = mysqli_real_escape_string($conn,$this->Email);
        $this->FirstName = mysqli_real_escape_string($conn,$this->FirstName);
        $this->LastName = mysqli_real_escape_string($conn,$this->LastName);
        $this->Password = mysqli_real_escape_string($conn,$this->Password);
        $this->PasswordLastSetOn = mysqli_real_escape_string($conn,$this->PasswordLastSetOn);
        $this->PasswordLastSetBy = mysqli_real_escape_string($conn,$this->PasswordLastSetBy);
        $this->PasswordLastSetByIP = mysqli_real_escape_string($conn,$this->PasswordLastSetByIP);
        $this->LastLoggedInOn = mysqli_real_escape_string($conn,$this->LastLoggedInOn);
        $this->IsLocked = mysqli_real_escape_string($conn,$this->IsLocked);
        $this->CreatedOn = mysqli_real_escape_string($conn,$this->CreatedOn);
        $this->CreatedBy = mysqli_real_escape_string($conn,$this->CreatedBy);
        $this->CreatedByIP = mysqli_real_escape_string($conn,$this->CreatedByIP);
        $this->LastModifiedOn = mysqli_real_escape_string($conn,$this->LastModifiedOn);
        $this->LastModifiedBy = mysqli_real_escape_string($conn,$this->LastModifiedBy);
        $this->LastModifiedByIP = mysqli_real_escape_string($conn,$this->LastModifiedByIP);
    }

    public function populateFromQuery($queryRow) {
        $this->UserID = $queryRow['UserID'];
        $this->Username = $queryRow['Username'];
        $this->Email = $queryRow['Email'];
        $this->FirstName = $queryRow['FirstName'];
        $this->LastName = $queryRow['LastName'];
        $this->Password = $queryRow['Password'];
        $this->PasswordLastSetOn = $queryRow['PasswordLastSetOn'];
        $this->PasswordLastSetBy = $queryRow['PasswordLastSetBy'];
        $this->PasswordLastSetByIP = $queryRow['PasswordLastSetByIP'];
        $this->LastLoggedInOn = $queryRow['LastLoggedInOn'];
        $this->IsLocked = $queryRow['IsLocked'];
        $this->CreatedOn = $queryRow['CreatedOn'];
        $this->CreatedBy = $queryRow['CreatedBy'];
        $this->CreatedByIP = $queryRow['CreatedByIP'];
        $this->LastModifiedOn = $queryRow['LastModifiedOn'];
        $this->LastModifiedBy = $queryRow['LastModifiedBy'];
        $this->LastModifiedByIP = $queryRow['LastModifiedByIP'];
        return $this;
    }

    public function getRoles() {
        $connection = mysqli_connect("localhost", "php", "password");

        if (!$connection) {
            $errorMsg = "no connection";
        } else { //connection was good
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "SELECT *
                            FROM USER_ROLES
                            LEFT JOIN ROLES
                                ON USER_ROLES.RoleID = ROLES.RoleID
                            WHERE UserID = $this->UserID;";
            $getUsersRoles = mysqli_query($connection, $queryString);
            mysqli_close($connection); // Closing Connection
            $userRoles = [];

            if (!is_bool($getUsersRoles)) {
                if (mysqli_num_rows($getUsersRoles) == 1) {
                    $getUsersRolesObj = $getUsersRoles->fetch_object();

                    $tempRoleStruct = new StdClass();
                    $tempRoleStruct->User_RoleID = $getUsersRolesObj->User_RoleID;
                    $tempRoleStruct->RoleID = $getUsersRolesObj->RoleID;
                    $tempRoleStruct->RoleName = $getUsersRolesObj->RoleName;
                    $tempRoleStruct->RoleDesc = $getUsersRolesObj->RoleDesc;
                    array_push($userRoles, $tempRoleStruct);
                } else if (mysqli_num_rows($getUsersRoles) > 0) {
                    $getUsersRoles->fetch_array();

                    foreach ($getUsersRoles as $role) {
                        $tempRoleStruct = new StdClass();
                        $tempRoleStruct->User_RoleID = $role['User_RoleID'];
                        $tempRoleStruct->RoleID = $role['RoleID'];
                        $tempRoleStruct->RoleName = $role['RoleName'];
                        $tempRoleStruct->RoleDesc = $role['RoleDesc'];
                        array_push($userRoles, $tempRoleStruct);
                    }
                }
            } else {
                //error, return empty
            }
        }
        return $userRoles;
    }

    public function getAllAvailableRoles() {
        $connection = mysqli_connect("localhost", "php", "password");

        if (!$connection) {
            $errorMsg = "no connection";
        } else { //connection was good
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "SELECT * FROM ROLES;";
            $getRoles = mysqli_query($connection, $queryString);
            mysqli_close($connection); // Closing Connection
            $roles = [];

            if (!is_bool($getRoles)) {
                if (mysqli_num_rows($getRoles) == 1) {
                    $getRolesObj = $getRoles->fetch_object();

                    $tempRoleStruct = new StdClass();
                    $tempRoleStruct->RoleID = $getRolesObj->RoleID;
                    $tempRoleStruct->RoleName = $getRolesObj->RoleName;
                    $tempRoleStruct->RoleDesc = $getRolesObj->RoleDesc;
                    array_push($roles, $tempRoleStruct);
                } else if (mysqli_num_rows($getRoles) > 0) {
                    $getRoles->fetch_array();

                    foreach ($getRoles as $role) {
                        $tempRoleStruct = new StdClass();
                        $tempRoleStruct->RoleID = $role['RoleID'];
                        $tempRoleStruct->RoleName = $role['RoleName'];
                        $tempRoleStruct->RoleDesc = $role['RoleDesc'];
                        array_push($roles, $tempRoleStruct);
                    }
                }
            } else {
                //error, return empty
            }
        }
        return $roles;
    }

}