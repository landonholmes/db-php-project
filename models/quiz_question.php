<?php
include_once "quiz_question_option.php";
class quiz_question {
    private $_never = '1970-01-01 00:00:00';
    public $QuestionID = 0;
    public $QuizID = 0;
    public $Text = "";
    public $Type = "";
    public $IsActive = 1;
    public $Options = [];

    public function load($quizQuestionID){
        if (!$quizQuestionID) {
            return $this;
        }

        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            //error connecting
        } else { //connection was good
            $quizQuestionID = mysqli_real_escape_string($connection, stripslashes($quizQuestionID));
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "SELECT * FROM QUIZ_QUESTIONS WHERE QuestionID='$quizQuestionID';";
            $qLoadQuiz = mysqli_query($connection, $queryString);

            mysqli_close($connection); // Closing Connection
            if (!is_bool($qLoadQuiz) && mysqli_num_rows($qLoadQuiz) == 1) {
                $qLoadQuizObj = $qLoadQuiz->fetch_object();

                $this->QuestionID = $qLoadQuizObj->QuestionID;
                $this->QuizID = $qLoadQuizObj->QuizID;
                $this->Text = $qLoadQuizObj->Text;
                $this->Type = $qLoadQuizObj->Type;
                $this->IsActive = $qLoadQuizObj->IsActive;

                $this->Options = $this->loadArrayOfQuizQuestionAnswers();
            } else {
                //error, return empty
            }

            return $this;
        }
    }

    public function save() {
        if ($this->QuestionID == 0) {
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
            $queryString = "INSERT INTO QUIZ_QUESTIONS(QuizID
                                ,Text
                                ,Type
                                ,IsActive)
                            VALUES (
                                '$this->QuizID'
                                ,'$this->Text'
                                ,'$this->Type'
                                ,'$this->IsActive'
                            );
                            ";
            $qCreateQuizQuestion = mysqli_query($connection, $queryString);
            $this->QuestionID = $connection->insert_id;

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
            $queryString = "UPDATE QUIZ_QUESTIONS
                            SET QuizID = '$this->QuizID'
                                ,Text = '$this->Text'
                                ,Type = '$this->Type'
                                ,IsActive = $this->IsActive
                                WHERE  QuestionID = '$this->QuestionID';
                            ";
            $qUpdateQuiz = mysqli_query($connection, $queryString);

            mysqli_close($connection); // Closing Connection
            return $this;
        }
    }

    private function enforceSQLProtection($conn) {
        $this->QuestionID = mysqli_real_escape_string($conn,$this->QuestionID);
        $this->QuizID = mysqli_real_escape_string($conn,$this->QuizID);
        $this->Text = mysqli_real_escape_string($conn,$this->Text);
        $this->Type = mysqli_real_escape_string($conn,$this->Type);
        $this->IsActive = mysqli_real_escape_string($conn,$this->IsActive);
    }

    public function populateFromQuery($queryRow) {
        $this->QuestionID = $queryRow['QuestionID'];
        $this->QuizID = $queryRow['QuizID'];
        $this->Text = $queryRow['Text'];
        $this->Type = $queryRow['Type'];
        $this->IsActive = $queryRow['IsActive'];
        $this->Options = $this->loadArrayOfQuizQuestionAnswers();
        return $this;
    }

    public function loadArrayOfQuizQuestionAnswers(){
        if (!$this->QuestionID) {
            return []; //no questions for an empty quiz
        }
        $questionID = $this->QuestionID;
        $tempArrayOfQuizQuestions = [];
        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            //error connecting
        } else { //connection was good
            $questionID = mysqli_real_escape_string($connection, stripslashes($questionID));
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "SELECT * FROM QUIZ_QUESTION_OPTIONS WHERE QuestionID='$questionID';";
            $qLoadQuizQuestionOptions = mysqli_query($connection, $queryString);

            mysqli_close($connection); // Closing Connection

            if (!is_bool($qLoadQuizQuestionOptions) && mysqli_num_rows($qLoadQuizQuestionOptions) > 0) {
                $qLoadQuizQuestionOptions->fetch_array();

                foreach ($qLoadQuizQuestionOptions as $quizQuestionOption) {
                    array_push($tempArrayOfQuizQuestions, (new quiz_question_option())->populateFromQuery($quizQuestionOption));
                }
            } else {
                //error, return empty
            }


            return $tempArrayOfQuizQuestions;
        }
    }

    //to be called after options have been loaded
    public function getAcceptableAnswers() {
        $tempIsAnswerOptions = [];

        foreach ($this->Options as $option) {
            if ($option->IsAnswer == 1) {
                array_push($tempIsAnswerOptions,$option);
            }
        }

        return $tempIsAnswerOptions;
    }

}