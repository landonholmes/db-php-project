<?php
include_once "models/quiz.php";
if (isset($_GET["quizID"]) && is_numeric($_GET["quizID"])) {
    $quizID = $_GET["quizID"];
} else {
    //we didn't get an id. abort
    redirect("$root/index.php?action=quizList");
}

$quiz = (new quiz())->load($quizID);

if ($quiz->IsActive == 0 || (count($quiz->Questions) < 1)) { //don't let them try to take inactive or empty quizzes
    redirect("$root/index.php?action=quizList");
}

function buildQuestionHTML($quizQuestion,$index) {
    $toReturn = "";
    switch($quizQuestion->Type) {
        case "Select": {
            $toReturn = $toReturn."<div class=\"form-group\">
                        <label class=\"control-label col-sm-2 label-required\" for=\"Question_$quizQuestion->QuestionID\">$index: $quizQuestion->Text:</label>
                        <div class=\"col-sm-5\">
                            <select id=\"Question_$quizQuestion->QuestionID\" name=\"Question_$quizQuestion->QuestionID\" class=\"form-control\" required>";
            foreach ($quizQuestion->Options as $quizQuestionOption) {
                $toReturn = $toReturn."<option value=\"$quizQuestionOption->Text\">$quizQuestionOption->Text</option>";
            }
            $toReturn = $toReturn."</select>
                        </div>
                    </div>";
            break;
        }
        case "Text": {
            $toReturn = $toReturn."<div class=\"form-group\">
                        <label class=\"control-label col-sm-2 label-required\" for=\"Question_$quizQuestion->QuestionID\">$index: $quizQuestion->Text:</label>
                        <div class=\"col-sm-5\">
                            <input id=\"Question_$quizQuestion->QuestionID\" name=\"Question_$quizQuestion->QuestionID\" class=\"form-control\" required value=\"\">";
            $toReturn = $toReturn."</div>
                    </div>";
            break;
        }
    }
    return $toReturn;
}
?>
<div class="row">
    <div class="col-sm-12">
        <h2>Taking Quiz: <?php print $quiz->Name;?></h2>
    </div>
</div>

<div class="row">
    <form class="form-horizontal" action="index.php?action=actQuizSubmit" method="POST">
        <?php
            $index = 1;
            foreach ($quiz->Questions as $quizQuestion) {
                if ($quizQuestion->IsActive && (count($quizQuestion->Options) > 0)) { //we only want active questions
                    echo buildQuestionHTML($quizQuestion,$index);
                }
            }

        ?>

        <div class="col-sm-offset-1 col-sm-6 well">
            <input type="hidden" name="lastModifiedBy" value="<?php print $_SESSION['loggedInUser']->UserID;?>" />
            <input type="hidden" name="quizID" value="<?php print $quiz->QuizID;?>" />
            <input type="submit" value="Submit" name="submit" class="btn btn-primary" id="accountSubmitButton" />
            <a class="btn btn-danger" id="quitTakingQuiz">Quit</a>
        </div>
    </form>
</div>
<script>
    $("a#quitTakingQuiz").on("click",function(e){
        var ask = window.confirm("Are you sure you want to quit taking the quiz? Your progress will not be saved.");
        if (ask) {
            document.location.href = "<?php echo "index.php?action=quizList"?>";

        }
    });

</script>