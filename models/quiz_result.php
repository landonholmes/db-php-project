<?php
class quiz_result {
    private $_never = '1970-01-01 00:00:00';
    public $QuizID = 0;
    public $UserID = 0;
    public $ResponseOn = '1970-01-01 00:00:00';
    public $Responses = [];

    public function load($userID,$quizID,$responseOn){
        if (!$userID) {
            return $this;
        }
        if (!$quizID) {
            return $this;
        }
        if ($responseOn == $this->_never) {
            return $this;
        }


        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            //error connecting
        } else { //connection was good
            $userID = mysqli_real_escape_string($connection, stripslashes($userID));
            $quizID = mysqli_real_escape_string($connection, stripslashes($quizID));
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "SELECT *
                            FROM RESPONSES
                            WHERE ResponseOn = '$responseOn'
                                AND UserID = $userID
                                AND QuizID = $quizID
                            ORDER BY ResponseOn DESC
                            ;";
            $qLoadResponse = mysqli_query($connection, $queryString);

            mysqli_close($connection); // Closing Connection
            if (!is_bool($qLoadResponse) && mysqli_num_rows($qLoadResponse) >  0) {
                $qLoadResponseObj = $qLoadResponse->fetch_object();

                $this->Responses = (new response())->loadAllForResponseOn($qLoadResponseObj->ResponseOn);
                $this->QuizID = $qLoadResponseObj->QuizID;
                $this->UserID = $qLoadResponseObj->UserID;
                $this->ResponseOn = $qLoadResponseObj->ResponseOn;

            } else {
                //error, return empty
            }

            return $this;
        }
    }

    public function loadLatest($userID,$quizID){
        if (!$userID) {
            return $this;
        }
        if (!$quizID) {
            return $this;
        }


        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            //error connecting
        } else { //connection was good
            $userID = mysqli_real_escape_string($connection, stripslashes($userID));
            $quizID = mysqli_real_escape_string($connection, stripslashes($quizID));
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "SELECT *
                            FROM RESPONSES
                            WHERE ResponseOn = (SELECT MAX(ResponseOn) FROM RESPONSES)
                                AND UserID = $userID
                                AND QuizID = $quizID
                            ORDER BY ResponseOn DESC
                            ;";
            $qLoadResponse = mysqli_query($connection, $queryString);

            mysqli_close($connection); // Closing Connection
            if (!is_bool($qLoadResponse) && mysqli_num_rows($qLoadResponse) >  0) {
                $qLoadResponseObj = $qLoadResponse->fetch_object();

                $this->Responses = (new response())->loadAllForResponseOn($qLoadResponseObj->ResponseOn);
                $this->QuizID = $qLoadResponseObj->QuizID;
                $this->UserID = $qLoadResponseObj->UserID;
                $this->ResponseOn = $qLoadResponseObj->ResponseOn;

            } else {
                //error, return empty
            }

            return $this;
        }
    }

    public function loadAllResultsForQuiz($userID,$quizID){
        $tempArrOfResults = [];
        if (!$userID) {
            return $tempArrOfResults;
        }
        if (!$quizID) {
            return $tempArrOfResults;
        }


        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            //error connecting
        } else { //connection was good
            $userID = mysqli_real_escape_string($connection, stripslashes($userID));
            $quizID = mysqli_real_escape_string($connection, stripslashes($quizID));
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "SELECT DISTINCT(ResponseOn),UserID,QuizID
                            FROM RESPONSES
                            WHERE  UserID = $userID
                                AND QuizID = $quizID
                            ORDER BY ResponseOn DESC
                            ;";
            $qLoadResponse = mysqli_query($connection, $queryString);

            mysqli_close($connection); // Closing Connection
            if (!is_bool($qLoadResponse)) {
                if (mysqli_num_rows($qLoadResponse) == 1) {
                    $qLoadResponseObj = $qLoadResponse->fetch_object();

                    array_push($tempArrOfResults,(new self())->load($userID,$quizID,$qLoadResponseObj->ResponseOn));
                } else if (mysqli_num_rows($qLoadResponse) > 0) {
                    $qLoadResponse->fetch_array();

                    foreach ($qLoadResponse as $singleResponse) {
                        array_push($tempArrOfResults,(new self())->load($userID,$quizID,$singleResponse['ResponseOn']));
                    }
                }
            } else {
                //error, return empty
            }

            return $tempArrOfResults;
        }
    }

    public function loadAllResultsForUser($userID){
        $tempArrOfResults = [];
        if (!$userID) {
            return $tempArrOfResults;
        }

        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            //error connecting
        } else { //connection was good
            $userID = mysqli_real_escape_string($connection, stripslashes($userID));
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "SELECT DISTINCT(ResponseOn),UserID,QuizID
                            FROM RESPONSES
                            WHERE  UserID = $userID
                            ORDER BY ResponseOn DESC
                            ;";
            $qLoadResponse = mysqli_query($connection, $queryString);

            mysqli_close($connection); // Closing Connection
            if (!is_bool($qLoadResponse)) {
                if (mysqli_num_rows($qLoadResponse) == 1) {
                    $qLoadResponseObj = $qLoadResponse->fetch_object();

                    array_push($tempArrOfResults,(new self())->load($userID,$qLoadResponseObj->QuizID,$qLoadResponseObj->ResponseOn));
                } else if (mysqli_num_rows($qLoadResponse) > 0) {
                    $qLoadResponse->fetch_array();

                    foreach ($qLoadResponse as $singleResponse) {
                        array_push($tempArrOfResults,(new self())->load($userID,$singleResponse['QuizID'],$singleResponse['ResponseOn']));
                    }
                }
            } else {
                //error, return empty
            }

            return $tempArrOfResults;
        }
    }

    public function getGrade() {
        if (!count($this->Responses)) {
            return 0;
        } else {
            $total = 0;
            $right = 0;
            foreach ($this->Responses as $singleResponse) {
                $total = $total+1;
                if ($singleResponse->IsCorrect) {
                    $right = $right+1;
                }
            }
            return number_format(floor(($right/$total)*10000)/100,2); //formatted like 100.00%
        }
    }


}