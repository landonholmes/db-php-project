<?php
include_once "models/quiz.php";
include_once "models/quiz_question.php";
include_once "models/quiz_response.php";
if (isset($_POST['submit']) && isset($_POST['quizID']) && isset($_SESSION['loggedInUserID'])) {
    //param'ing for quizID
    if (is_numeric($_POST['quizID'])) {
        $quizID = $_POST['quizID'];
    } else {
        redirect("$root/index.php?action=quizList"); //they probably broke something
    }

    $quiz = (new quiz())->load($quizID); //load a model
    $rightNow = date("Y-m-d H:i:s");

    $answeredQuestions = []; //this will keep track of responses found and is used to check to make sure the user did not delete any responses.

    foreach($_POST as $inputName => $inputValue)
    {

        if (strpos($inputName,'Question_') !== false) {
            $quizQuestionID = explode("_",$inputName)[1];
            $specificQuestion = array_filter($quiz->Quiz_Questions,function ($question) use ($quizQuestionID) {
                    return $question->QuestionID == $quizQuestionID;
                }
            );

            if (count($specificQuestion) > 0) {
                $specificQuestion = array_values($specificQuestion)[0];
                array_push($answeredQuestions,$specificQuestion); //add the found question that they answered to our array of answered questions
                $specificOption = array_filter($specificQuestion->Options,function ($option) use ($inputValue) {
                        return $option->Text == $inputValue;
                    }
                );

                if (count($specificOption) > 0) {
                    $specificOption = array_values($specificOption)[0];
                } else {
                    $specificOption = new quiz_question_option();
                }
            } else {
                $specificQuestion = new quiz_question();
                $specificOption = new quiz_question_option();
            }

            $quizResponse = new quiz_response();
            $quizResponse->QuizID = $quizID;
            $quizResponse->UserID = $_SESSION['loggedInUserID'];
            $quizResponse->QuestionText = $specificQuestion->Text;
            $quizResponse->QuestionID = $specificQuestion->QuestionID;
            $quizResponse->OptionText = $specificOption->Text;
            $quizResponse->QuestionOptionID = $specificOption->QuestionOptionID;
            $quizResponse->Response = $inputValue;
            $quizResponse->IsCorrect = $specificOption->IsAnswer;
            $quizResponse->ResponseOn = $rightNow;

            $quizResponse->save();
        }
    }

    $unansweredQuestions = array_udiff($quiz->getActiveQuizQuestions(),$answeredQuestions,
        function($question_one,$question_two){
            return $question_one->QuestionID - $question_two->QuestionID; //this is a minus because 0 is false, and 1 is true for this inner function (comparisons using == would return true/false)
        });

    foreach ($unansweredQuestions as $unansQ) {
        $quizResponse = new quiz_response();
        $quizResponse->QuizID = $quizID;
        $quizResponse->UserID = $_SESSION['loggedInUserID'];
        $quizResponse->QuestionText = $unansQ->Text;
        $quizResponse->QuestionID = $unansQ->QuestionID;
        $quizResponse->OptionText = "";
        $quizResponse->QuestionOptionID = 0;
        $quizResponse->Response = $inputValue;
        $quizResponse->IsCorrect = 0;
        $quizResponse->ResponseOn = $rightNow;

        $quizResponse->save();
    }

    redirect("$root/index.php?action=quizResults&userID=".$_SESSION['loggedInUserID']."&quizID=$quiz->QuizID");
} else {
    redirect("$root/index.php?action=quizList");
}





