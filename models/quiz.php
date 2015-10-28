<?php
class quiz {
    private $_never = '1970-01-01 00:00:00';
    public $QuizID = 0;
    public $Name = "";
    public $Description = "";
    public $IsActive = 1;

    public function load($quizID){
        if (!$quizID) {
            return $this;
        }

        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            //error connecting
        } else { //connection was good
            $quizID = mysqli_real_escape_string($connection, stripslashes($quizID));
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "SELECT * FROM QUIZ WHERE QuizID='$quizID';";
            $qLoadQuiz = mysqli_query($connection, $queryString);

            if (!is_bool($qLoadQuiz) && mysqli_num_rows($qLoadQuiz) == 1) {
                $qLoadQuizObj = $qLoadQuiz->fetch_object();

                $this->QuizID = $qLoadQuizObj->QuizID;
                $this->Name = $qLoadQuizObj->Name;
                $this->Description = $qLoadQuizObj->Description;
                $this->IsActive = $qLoadQuizObj->IsActive;
            } else {
                //error, return empty
            }

            mysqli_close($connection); // Closing Connection
            return $this;
        }
    }

    public function save() {
        if ($this->QuizID == 0) {
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
            $queryString = "INSERT INTO QUIZ(Name
                                ,Description
                                ,IsActive)
                            VALUES (
                                '$this->Name'
                                ,'$this->Description'
                                ,'$this->IsActive'
                            );
                            ";
            $qCreateUser = mysqli_query($connection, $queryString);
            $this->QuizID = $connection->insert_id;


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
            $queryString = "UPDATE QUIZ
                            SET Name = '$this->Name'
                                ,Description = '$this->Description'
                                ,IsActive = $this->IsActive
                                WHERE  QuizID = '$this->QuizID';
                            ";
            $qUpdateQuiz = mysqli_query($connection, $queryString);

            mysqli_close($connection); // Closing Connection
            return $this;
        }
    }

    private function enforceSQLProtection($conn) {
        $this->QuizID = mysqli_real_escape_string($conn,$this->QuizID);
        $this->Name = mysqli_real_escape_string($conn,$this->Name);
        $this->Description = mysqli_real_escape_string($conn,$this->Description);
        $this->IsActive = mysqli_real_escape_string($conn,$this->IsActive);
    }

    public function populateFromQuery($queryRow) {
        $this->QuizID = $queryRow['QuizID'];
        $this->Name = $queryRow['Name'];
        $this->Description = $queryRow['Description'];
        $this->IsActive = $queryRow['IsActive'];
        return $this;
    }

}