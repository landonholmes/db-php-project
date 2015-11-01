<?php
include_once "models/quiz.php";
include_once "models/response.php";
include_once "models/quiz_result.php";
$userList = [];
if (isset($_GET["userID"]) && is_numeric($_GET["userID"])) {
    array_push($userList,(new user())->load($_GET["userID"]));
} else {
    $userList =  (new user())->loadAll();

}
if (isset($_GET["quizID"]) && is_numeric($_GET["quizID"])) {
    $quizID = $_GET["quizID"];
} else {
    $quizID = 0;
}



?>

<?php
    foreach($userList as $user) {
        $results = (new quiz_result)->loadAllResultsForUser($user->UserID);
        echo "<div class=\"row\">
                <div class=\"col-sm-12\">
                <h3><a href=\"index.php?action=userResults&userID=$user->UserID\">$user->FirstName $user->LastName</a>'s Results</h3>";
                if (count($results) < 1) {
                    echo "No Results found for user.";
                } else {
                    echo "<table class=\"table table-condensed table-bordered table-hover\">

                                <tr>
                                   <th style=\"width: 20%;\">Quiz Name</th>
                                   <th style=\"width: 20%;\">Taken On</th>
                                   <th style=\"width: 10%;\">Grade</th>
                                   <th style=\"width: 50%;\">&nbsp;</th>
                                </tr>";

                    foreach ($results as $result) {
                        $quizGrade = $result->getGrade();
                        echo "<tr>
                                    <td>" . (new quiz())->load($result->QuizID)->Name . "</td>
                                    <td>$result->ResponseOn</td>
                                    <td>$quizGrade%</td>
                                    <td>
                                        <div class=\"progress\">
                                            <div class=\"progress-bar progress-bar-info\" role=\"progressbar\" data-pct=\"$quizGrade\" aria-valuenow=\"$quizGrade\"
                                                 aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: $quizGrade%\">
                                                $quizGrade%
                                            </div>
                                        </div>
                                    </td>
                                </tr>";
                    }
                    echo "</table>";
                }
        echo "</div>
        </div>";
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