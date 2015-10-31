<?php
class quiz_question_option {
    private $_never = '1970-01-01 00:00:00';
    public $QuestionOptionID = 0;
    public $QuestionID = 0;
    public $Text = "";
    public $IsAnswer = 0;

    public function load($questionOptionID){
        if (!$questionOptionID) {
            return $this;
        }

        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            //error connecting
        } else { //connection was good
            $questionOptionID = mysqli_real_escape_string($connection, stripslashes($questionOptionID));
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "SELECT * FROM QUIZ_QUESTION_OPTIONS WHERE QuestionOptionID='$questionOptionID';";
            $qLoadQuiz = mysqli_query($connection, $queryString);

            if (!is_bool($qLoadQuiz) && mysqli_num_rows($qLoadQuiz) == 1) {
                $qLoadQuizObj = $qLoadQuiz->fetch_object();

                $this->QuestionOptionID = $qLoadQuizObj->QuestionOptionID;
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
                            FROM QUIZ_QUESTION_OPTIONS
                            WHERE QuestionID = '$questionID'
                                AND Text = '$text';";
            $qLoadQuiz = mysqli_query($connection, $queryString);

            mysqli_close($connection); // Closing Connection
            if (!is_bool($qLoadQuiz) && mysqli_num_rows($qLoadQuiz) == 1) {
                $qLoadQuizObj = $qLoadQuiz->fetch_object();

                $this->QuestionOptionID = $qLoadQuizObj->QuestionOptionID;
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
        if ($this->QuestionOptionID == 0) {
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
            $queryString = "INSERT INTO QUIZ_QUESTION_OPTIONS(QuestionID
                                ,Text
                                ,IsAnswer)
                            VALUES (
                                '$this->QuestionID'
                                ,'$this->Text'
                                ,'$this->IsAnswer'
                            );
                            ";
            $qCreateUser = mysqli_query($connection, $queryString);
            $this->QuestionOptionID = $connection->insert_id;


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
            $queryString = "UPDATE QUIZ_QUESTION_OPTIONS
                            SET QuestionID = '$this->QuestionID'
                                ,Text = '$this->Text'
                                ,IsAnswer = $this->IsAnswer
                                WHERE  QuestionOptionID = '$this->QuestionOptionID';
                            ";
            $qUpdateQuiz = mysqli_query($connection, $queryString);

            mysqli_close($connection); // Closing Connection
            return $this;
        }
    }

    private function enforceSQLProtection($conn) {
        $this->QuestionOptionID = mysqli_real_escape_string($conn,$this->QuestionOptionID);
        $this->QuestionID = mysqli_real_escape_string($conn,$this->QuestionID);
        $this->Text = mysqli_real_escape_string($conn,$this->Text);
        $this->IsAnswer = mysqli_real_escape_string($conn,$this->IsAnswer);
    }

    public function populateFromQuery($queryRow) {
        $this->QuestionOptionID = $queryRow['QuestionOptionID'];
        $this->QuestionID = $queryRow['QuestionID'];
        $this->Text = $queryRow['Text'];
        $this->IsAnswer = $queryRow['IsAnswer'];
        return $this;
    }

}