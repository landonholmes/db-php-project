<?php
include_once "models/quiz.php";
include_once "models/quiz_question.php";
if (isset($_POST['submit']) && isset($_POST['quizID']) && isset($_SESSION['loggedInUserID'])) {
    //param'ing for quizID
    if (is_numeric($_POST['quizID'])) {
        $quizID = $_POST['quizID'];
    } else {
        redirect("$root/index.php?action=quizList"); //they probably broke something
    }

    $quiz = (new quiz())->load($quizID); //load a model
d($quiz);
d($_POST);

    foreach($_POST as $key => $value)
    {

        if (strpos($key,'Question_') !== false) {
            $quizQuestionID = explode("_",$key)[1];
            d($quizQuestionID);
            $loadedQuestion = (new quiz_question())->load($quizQuestionID);
            //check if correct somehow
        }
    }

    //redirect("$root/index.php?action=quizResults&quizID=$quiz->QuizID");
} else {
    redirect("$root/index.php?action=quizList");
}





