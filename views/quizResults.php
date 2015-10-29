<?php
include_once "models/quiz.php";
include_once "models/quiz_response.php";
include_once "models/quiz_result.php";
if (isset($_GET["userID"]) && is_numeric($_GET["userID"])) {
    $userID = $_GET["userID"];
} else {
    //we didn't get an id. abort
    redirect("$root/index.php?action=manageQuiz");
}
if (isset($_GET["quizID"]) && is_numeric($_GET["quizID"])) {
    $quizID = $_GET["quizID"];
} else {
    $quizID = 0;
}
$quizResults = [];
if ($quizID) { //given a specific quiz, load all for that
    $quizResults = (new quiz_result())->loadAllResultsForQuiz($userID,$quizID);
} else {
    $quizResults = (new quiz_result())->loadAllResultsForUser($userID);
}

?>

<?php
    if (!count($quizResults)) {
        echo "<div class=\"row\">
                <div class=\"col-sm-12\">
                    <h2>No quiz results found.</h2>
                </div>
            </div>";
    } else {
        foreach($quizResults as $quizResult) {
            echo "<div class=\"row\">
                    <div class=\"col-sm-12\">
                        <h2>Quiz Results for:".(new quiz())->load($quizResult->QuizID)->Name." on $quizResult->ResponseOn </h2>
                        ".$quizResult->getGrade()."
                    </div>
                </div>";
        }
    }

?>


<div class="row">

</div>
<script>


</script>