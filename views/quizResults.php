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

$quiz = (new quiz())->load($quizID);

$quizResults = (new quiz_result())->loadLatest($userID,$quizID);
d($quizResults);
?>
<div class="row">
    <div class="col-sm-12">
        <h2>Quiz Results for: <?php print $quiz->Name;?></h2>
    </div>
</div>

<div class="row">

</div>
<script>


</script>