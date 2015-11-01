<?php
include_once "models/quiz.php";
include_once "models/response.php";
include_once "models/quiz_result.php";
if (isset($_GET["userID"]) && is_numeric($_GET["userID"])) {
    $userID = $_GET["userID"];
} else {
    //we didn't get an id, assume logged in user's id
    $userID = $_SESSION["loggedInUserID"];
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
                        <div class=\"row\">
                            <h4>Quiz Results for: ".(new quiz())->load($quizResult->QuizID)->Name." on $quizResult->ResponseOn </h4>
                            <div class=\"col-sm-2\">Grade: $quizGrade%</div>
                            <div class=\" col-sm-10\">
                                <div class=\"progress\">
                                    <div class=\"progress-bar progress-bar-info\" role=\"progressbar\" data-pct=\"$quizGrade\" aria-valuenow=\"$quizGrade\"
                                         aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: $quizGrade%\">
                                        $quizGrade%
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=\"row\">
                            <table class=\"table table-bordered table-condensed table-hover\">
                                <tr>
                                    <th style=\"width: 30%\">Question Text</th>
                                    <th style=\"width: 30%\">Your Answer:</th>
                                    <th style=\"width: 10%\">Right/Wrong</th>
                                    <th style=\"width: 30%\">Correct Answer(s):</th>
                                </tr>";
                        foreach ($quizResult->Responses as $response) {
                            echo "<tr>
                                <td>$response->QuestionText</td>
                                <td>$response->Response</td>";
                                if ($response->IsCorrect == 1) {
                                    echo "<td style=\"background-color: #5cb85c; text-align: center;\"><i class=\"glyphicon glyphicon-ok\"></i></td>";
                                } else {
                                    echo "<td style=\"background-color: #d9534f; text-align: center;\"><i class=\"glyphicon glyphicon-remove\"></i></td>";
                                }
                            echo "</td>
                                <td>$response->CorrectResponse</td>
                            </tr>";
                        }

                        echo "</table>
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