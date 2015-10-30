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
            $quizGrade = $quizResult->getGrade();
            echo "<div class=\"row\">
                    <div class=\"col-sm-12\">
                        <h2>Quiz Results for: ".(new quiz())->load($quizResult->QuizID)->Name." on $quizResult->ResponseOn </h2>
                        <div class=\"progress\">
								<div class=\"progress-bar progress-bar-info\" role=\"progressbar\" data-pct=\"$quizGrade\" aria-valuenow=\"$quizGrade\"
									 aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: $quizGrade%\">
									$quizGrade%
								</div>
							</div>
                    </div>
                </div><hr/>";
        }
    }

?>


<div class="row">

</div>
<script>
    $(document).ready(function(e){
        var progressBars = $("div.progress-bar");

        if (progressBars.length > 0) {
            _.forEach(progressBars,function(bar,index){
                //change color based on pct
                var pct = $(bar).attr("data-pct");
                if (pct < 60) {
                    $(bar).attr("class","progress-bar progress-bar-danger");
                } else if (pct <= 80) {
                    $(bar).attr("class","progress-bar progress-bar-warning");
                } else if (pct <= 100) {
                    $(bar).attr("class","progress-bar progress-bar-success");
                }
                //check if width is set above 100%, then set back to 100%
                var currentWidth = $(bar)[0].style.width;
                if( (parseInt(currentWidth.substring(0, currentWidth.length - 1))) > 100) {
                    $(bar)[0].style.width = "100%";
                }
            });
        }
    });
</script>