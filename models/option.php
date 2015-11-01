<?php
class option {
    private $_never = '1970-01-01 00:00:00';
    public $OptionID = 0;
    public $QuestionID = 0;
    public $Text = "";
    public $IsAnswer = 0;

    public function load($optionID){
        if (!$optionID) {
            return $this;
        }

        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            //error connecting
        } else { //connection was good
            $optionID = mysqli_real_escape_string($connection, stripslashes($optionID));
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "SELECT * FROM OPTIONS WHERE OptionID='$optionID';";
            $qLoadQuiz = mysqli_query($connection, $queryString);

            if (!is_bool($qLoadQuiz) && mysqli_num_rows($qLoadQuiz) == 1) {
                $qLoadQuizObj = $qLoadQuiz->fetch_object();

                $this->OptionID = $qLoadQuizObj->OptionID;
                $this->QuestionID = $qLoadQuizObj->QuestionID;
                $this->Text = $qLoadQuizObj->Text;
                $this->IsAnswer = $qLoadQuizObj->IsAnswer;

            } else {
                //error, return empty
            }

            mysqli_close($connection); // Closing Connection
            return $this;
        }
    }

    public function loadOptionForQuizForQuestion($questionID,$text){
        if (!$questionID) {
            return $this;
        }

        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            //error connecting
        } else { //connection was good
            $questionID = mysqli_real_escape_string($connection, stripslashes($questionID));
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "SELECT *
                            FROM OPTIONS
                            WHERE QuestionID = '$questionID'
                                AND Text = '$text';";
            $qLoadQuiz = mysqli_query($connection, $queryString);

            mysqli_close($connection); // Closing Connection
            if (!is_bool($qLoadQuiz) && mysqli_num_rows($qLoadQuiz) == 1) {
                $qLoadQuizObj = $qLoadQuiz->fetch_object();

                $this->OptionID = $qLoadQuizObj->OptionID;
                $this->QuestionID = $qLoadQuizObj->QuestionID;
                $this->Text = $qLoadQuizObj->Text;
                $this->IsAnswer = $qLoadQuizObj->IsAnswer;

            } else {
                //error, return empty
            }

            return $this;
        }
    }

    public function save() {
        if ($this->OptionID == 0) {
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
            $queryString = "INSERT INTO OPTIONS(QuestionID
                                ,Text
                                ,IsAnswer)
                            VALUES (
                                '$this->QuestionID'
                                ,'$this->Text'
                                ,$this->IsAnswer
                            );
                            ";
            $qCreateUser = mysqli_query($connection, $queryString);
            $this->OptionID = $connection->insert_id;


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
            $queryString = "UPDATE OPTIONS
                            SET QuestionID = '$this->QuestionID'
                                ,Text = '$this->Text'
                                ,IsAnswer = $this->IsAnswer
                                WHERE  OptionID = '$this->OptionID';
                            ";
            $qUpdateQuiz = mysqli_query($connection, $queryString);

            mysqli_close($connection); // Closing Connection
            return $this;
        }
    }

    //assumes record does exist in DB and intends to update that one
    public function delete() {
        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            //error connecting
        } else { //connection was good
            $this->enforceSQLProtection($connection);
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "DELETE FROM OPTIONS
                            WHERE  OptionID = '$this->OptionID';
                            ";
            $qUpdateQuiz = mysqli_query($connection, $queryString);

            mysqli_close($connection); // Closing Connection
            return $this;
        }
    }

    private function enforceSQLProtection($conn) {
        $this->OptionID = mysqli_real_escape_string($conn,$this->OptionID);
        $this->QuestionID = mysqli_real_escape_string($conn,$this->QuestionID);
        $this->Text = mysqli_real_escape_string($conn,$this->Text);
        $this->IsAnswer = mysqli_real_escape_string($conn,$this->IsAnswer);
    }

    public function populateFromQuery($queryRow) {
        $this->OptionID = $queryRow['OptionID'];
        $this->QuestionID = $queryRow['QuestionID'];
        $this->Text = $queryRow['Text'];
        $this->IsAnswer = $queryRow['IsAnswer'];
        return $this;
    }

}