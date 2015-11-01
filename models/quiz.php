<?php
include_once "question.php";
class quiz {
    private $_never = '1970-01-01 00:00:00';
    public $QuizID = 0;
    public $Name = "";
    public $Description = "";
    public $IsActive = 1;
    public $Questions = [];

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

            mysqli_close($connection); // Closing Connection
            if (!is_bool($qLoadQuiz) && mysqli_num_rows($qLoadQuiz) == 1) {
                $qLoadQuizObj = $qLoadQuiz->fetch_object();

                $this->QuizID = $qLoadQuizObj->QuizID;
                $this->Name = $qLoadQuizObj->Name;
                $this->Description = $qLoadQuizObj->Description;
                $this->IsActive = $qLoadQuizObj->IsActive;

                $this->Questions = $this->loadArrayOfQuizQuestions();
            } else {
                //error, return empty
            }

            return $this;
        }
    }

    public function loadAll() {
        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            $errorMsg = "no connection";
        } else { //connection was good
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "SELECT * FROM QUIZ;";
            $getQuizzes = mysqli_query($connection, $queryString);
            mysqli_close($connection); // Closing Connection
            $quizList = array();
            if (is_bool($getQuizzes) && !$getQuizzes) {
                $errorMsg = "bad query";
            } else {
                $getQuizzes->fetch_array();
                foreach ($getQuizzes as $quizThing) {
                    array_push($quizList, (new quiz())->populateFromQuery($quizThing));
                }
            }
        }

        return $quizList;
    }

    public function loadAllActive() {
        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            $errorMsg = "no connection";
        } else { //connection was good
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "SELECT * FROM QUIZ WHERE IsActive = 1;";
            $getQuizzes = mysqli_query($connection, $queryString);
            mysqli_close($connection); // Closing Connection
            $quizList = array();
            if (is_bool($getQuizzes) && !$getQuizzes) {
                $errorMsg = "bad query";
            } else {
                $getQuizzes->fetch_array();
                foreach ($getQuizzes as $quizThing) {
                    array_push($quizList, (new quiz())->populateFromQuery($quizThing));
                }
            }
        }

        return $quizList;
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
        $this->Questions = $this->loadArrayOfQuizQuestions();
        return $this;
    }

    public function loadArrayOfQuizQuestions(){
        if (!$this->QuizID) {
            return []; //no questions for an empty quiz
        }
        $quizID = $this->QuizID;
        $tempArrayOfQuizQuestions = [];
        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            //error connecting
        } else { //connection was good
            $quizID = mysqli_real_escape_string($connection, stripslashes($quizID));
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "SELECT * FROM QUESTIONS WHERE QuizID='$quizID';";
            $qLoadQuizQuestions = mysqli_query($connection, $queryString);
            mysqli_close($connection); // Closing Connection
            if (!is_bool($qLoadQuizQuestions) && mysqli_num_rows($qLoadQuizQuestions) > 0) {
                $qLoadQuizQuestionsObj = $qLoadQuizQuestions->fetch_array();

                foreach ($qLoadQuizQuestions as $quizQuestion) {
                    array_push($tempArrayOfQuizQuestions, (new question())->populateFromQuery($quizQuestion));
                }
            } else {
                //error, return empty
            }

            return $tempArrayOfQuizQuestions;
        }
    }

    public function getActiveQuizQuestions(){
        if (!$this->QuizID) {
            return []; //no questions for an empty quiz
        }
        $tempArrayOfQuizQuestions = []; //temp var

        foreach ($this->Questions as $quizQuestion) { //loop through our questions
            if ($quizQuestion->IsActive == 1 && count($quizQuestion->Options) > 0) { //only get valid ones (active and has options)
                array_push($tempArrayOfQuizQuestions, $quizQuestion);
            }
        }

        return $tempArrayOfQuizQuestions;
    }

}