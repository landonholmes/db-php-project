<?php
include "models/quiz.php";
if (isset($_POST['submit']) && isset($_POST['quizID'])) {
    //param'ing for quizID
    if (is_numeric($_POST['quizID'])) {
        $quizID = $_POST['quizID'];
    } else {
        $quizID = 0; //default to 0
    }

    $quiz = (new quiz())->load($quizID); //load a model

    $quiz->Name = $_POST['name'];
    $quiz->Description = $_POST['description'];
    $quiz->IsActive = $_POST['isActive'];

    $quiz = $quiz->save();
    redirect("$root/index.php?action=quizDetail&quizID=$quiz->QuizID");
} else {
    redirect("$root/index.php?action=manageQuiz");
}





