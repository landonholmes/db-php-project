<?php
class response {
    private $_never = '1970-01-01 00:00:00';
    public $ResponseID = 0;
    public $QuizID = 0;
    public $UserID = 0;
    public $QuestionText = "";
    public $QuestionID = 0;
    public $OptionText = "";
    public $OptionID = 0;
    public $Response = "";
    public $CorrectResponse = "";
    public $IsCorrect = 0;
    public $ResponseOn = '1970-01-01 00:00:00';

    public function load($responseID){
        if (!$responseID) {
            return $this;
        }

        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            //error connecting
        } else { //connection was good
            $responseID = mysqli_real_escape_string($connection, stripslashes($responseID));
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "SELECT * FROM RESPONSES WHERE ResponseID='$responseID';";
            $qLoadResponse = mysqli_query($connection, $queryString);

            mysqli_close($connection); // Closing Connection
            if (!is_bool($qLoadResponse) && mysqli_num_rows($qLoadResponse) == 1) {
                $qLoadResponseObj = $qLoadResponse->fetch_object();

                $this->ResponseID = $qLoadResponseObj->ResponseID;
                $this->QuizID = $qLoadResponseObj->QuizID;
                $this->UserID = $qLoadResponseObj->UserID;
                $this->QuestionText = $qLoadResponseObj->QuestionText;
                $this->QuestionID = $qLoadResponseObj->QuestionID;
                $this->OptionText = $qLoadResponseObj->OptionText;
                $this->OptionID = $qLoadResponseObj->OptionID;
                $this->Response = $qLoadResponseObj->Response;
                $this->CorrectResponse = $qLoadResponseObj->CorrectResponse;
                $this->IsCorrect = $qLoadResponseObj->IsCorrect;
                $this->ResponseOn = $qLoadResponseObj->ResponseOn;

            } else {
                //error, return empty
            }

            return $this;
        }
    }

    public function loadAllForResponseOn($responseOn){
        if ($responseOn == $this->_never) {
            return $this;
        }

        $tempArrayOfResponses = [];

        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            //error connecting
        } else { //connection was good
            $responseOn = mysqli_real_escape_string($connection, stripslashes($responseOn));
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "SELECT * FROM RESPONSES WHERE ResponseOn='$responseOn';";
            $qLoadResponse = mysqli_query($connection, $queryString);

            mysqli_close($connection); // Closing Connection
            if (!is_bool($qLoadResponse)) {
                if (mysqli_num_rows($qLoadResponse) == 1) {
                    $qLoadResponseObj = $qLoadResponse->fetch_object();

                    $this->ResponseID = $qLoadResponseObj->ResponseID;
                    array_push($tempArrayOfResponses,(new self())->load($qLoadResponseObj->ResponseID));
                } else if (mysqli_num_rows($qLoadResponse) > 0) {
                    $qLoadResponse->fetch_array();

                    foreach ($qLoadResponse as $singleResponse) {
                        array_push($tempArrayOfResponses,(new self())->populateFromQuery($singleResponse));
                    }
                }
            } else {
                //error, return empty
            }

            return $tempArrayOfResponses;
        }
    }

    public function save() {
        if ($this->ResponseID == 0) {
            return $this->create();
        } else {
            return $this->update();
        }

    }

    //assumes record does not exist in DB and intends to insert one
    private function create() {
        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            //error connecting
        } else { //connection was good
            $this->enforceSQLProtection($connection);
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "INSERT INTO RESPONSES(QuizID
                                ,UserID
                                ,QuestionText
                                ,QuestionID
                                ,OptionText
                                ,OptionID
                                ,Response
                                ,CorrectResponse
                                ,IsCorrect
                                ,ResponseOn)
                            VALUES (
                                $this->QuizID
                                ,$this->UserID
                                ,'$this->QuestionText'
                                ,$this->QuestionID
                                ,'$this->OptionText'
                                ,'$this->OptionID'
                                ,'$this->Response'
                                ,'$this->CorrectResponse'
                                ,$this->IsCorrect
                                ,'$this->ResponseOn'
                            );
                            ";
            $qCreateResponse = mysqli_query($connection, $queryString);
            $this->ResponseID = $connection->insert_id;

            mysqli_close($connection); // Closing Connection
            return $this;
        }
    }

    //assumes record does exist in DB and intends to update that one
    private function update() {
        $connection = mysqli_connect("localhost", "php", "password");
        if (!$connection) {
            //error connecting
        } else { //connection was good
            $this->enforceSQLProtection($connection);
            $db = mysqli_select_db($connection, "DB_PHP");
            $queryString = "UPDATE RESPONSES
                            SET QuizID = $this->QuizID
                                ,UserID = $this->UserID
                                ,QuestionText = '$this->QuestionText'
                                ,QuestionID = $this->QuestionID
                                ,OptionText = '$this->OptionText'
                                ,OptionID = $this->OptionID
                                ,Response = '$this->Response'
                                ,CorrectResponse = '$this->CorrectResponse'
                                ,IsCorrect = $this->IsCorrect
                                ,ResponseOn = '$this->ResponseOn'
                                WHERE  ResponseID = '$this->ResponseID';
                            ";
            $qUpdateResponse = mysqli_query($connection, $queryString);

            mysqli_close($connection); // Closing Connection
            return $this;
        }
    }

    private function enforceSQLProtection($conn) {
        $this->ResponseID = mysqli_real_escape_string($conn,$this->ResponseID);
        $this->QuizID = mysqli_real_escape_string($conn,$this->QuizID);
        $this->UserID = mysqli_real_escape_string($conn,$this->UserID);
        $this->QuestionText = mysqli_real_escape_string($conn,$this->QuestionText);
        $this->QuestionID = mysqli_real_escape_string($conn,$this->QuestionID);
        $this->OptionText = mysqli_real_escape_string($conn,$this->OptionText);
        $this->OptionID = mysqli_real_escape_string($conn,$this->OptionID);
        $this->Response = mysqli_real_escape_string($conn,$this->Response);
        $this->CorrectResponse = mysqli_real_escape_string($conn,$this->CorrectResponse);
        $this->IsCorrect = mysqli_real_escape_string($conn,$this->IsCorrect);
        $this->ResponseOn = mysqli_real_escape_string($conn,$this->ResponseOn);
    }

    public function populateFromQuery($queryRow) {
        $this->ResponseID = $queryRow['ResponseID'];
        $this->QuizID = $queryRow['QuizID'];
        $this->UserID = $queryRow['UserID'];
        $this->QuestionText = $queryRow['QuestionText'];
        $this->QuestionID = $queryRow['QuestionID'];
        $this->OptionText = $queryRow['OptionText'];
        $this->OptionID = $queryRow['OptionID'];
        $this->Response = $queryRow['Response'];
        $this->CorrectResponse = $queryRow['CorrectResponse'];
        $this->IsCorrect = $queryRow['IsCorrect'];
        $this->ResponseOn = $queryRow['ResponseOn'];
        return $this;
    }


}