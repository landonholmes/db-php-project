<?php
include "models/quiz.php";
if (isset($_GET["quizID"]) && is_numeric($_GET["quizID"])) {
    $quizID = $_GET["quizID"];
} else {
    //we didn't get an id. abort
    redirect("$root/index.php?action=manageUsers");
}
$quiz = (new quiz())->load($quizID);
?>

<div class="row">
        <?php
            echo "
            <div class=\"col-sm-8\">
                <h2>Quiz Detail: $quiz->Name</h2>

                <table class=\"table table-condensed table-detail\">
                    <tr>
                        <th width=\"200\">
                            Name:
                        </th>
                        <td>
                            $quiz->Name
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Description:
                        </th>
                        <td>
                            $quiz->Description &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Status:
                        </th>
                        <td>";
                        if ($quiz->IsActive == 0) {
                            echo "<span class=\"label label-warning\">Locked</span>";
                        } else {
                            echo "<span class=\"label label-info\">Active</span>";
                        }
                echo "</td>
                    </tr>
                </table>
            </div>
            <div class=\"col-sm-4\"><br />
            <div class=\"well\">
                <p>To update this quiz, click the button below.</p>
                <a href=\"index.php?action=quizForm&quizID=$quizID\" class=\"btn btn-default\">Update User</a>
            </div>
        </div>";
        ?>
</div>
<br />
<div class="row quiz-question-row">
    <div class="col-sm-12">
        <h2>Questions:<a class="btn btn-sm btn-info" id="new-question-button" style="float:right;margin-top:5px;">New Question</a></h2>
        <table class="table table-condensed table-detail">
            <tr>
                <th>Text</th>
                <th>Type</th>
                <th>Status</th>
                <th>Options (<span style="font-weight:bold;text-decoration:underline;">answer</span>)</th>
                <th>&nbsp;</th>
            </tr>
            <?php
                foreach ($quiz->Quiz_Questions as $quizQuestion) {
                    echo "
                    <tr>
                        <td>$quizQuestion->Text</td>
                        <td>$quizQuestion->Type</td>
                        <td>";
                    if ($quizQuestion->IsActive == 0) {
                        echo "<span class=\"label label-warning\">Locked</span>";
                    } else {
                        echo "<span class=\"label label-info\">Active</span>";
                    }
                    echo "</td>
                        <td>";
                        echo "<ul>";
                        foreach ($quizQuestion->Options as $quizQuestionOption) {
                            echo "<li";
                            if ($quizQuestionOption->IsAnswer == 1) {
                                echo " style=\"font-weight:bold; text-decoration:underline;\"";
                            }
                            echo ">$quizQuestionOption->Text</li>";
                        }
                        echo "</ul>";
                    echo "</td>
                        <td>Disable</td>
                    </tr>
                    ";
                }
            ?>
        </table>
        <script>
            var quizID = "<?php print($quiz->QuizID); ?>";
            var quizQuestionRowTemplate = _.template("");
            var quizQuestionFormTemplate = _.template('<tr class="quiz-question-form" id="<%= formID %>">' +
                '<td><input type="text" class="form-control" name="quizOption"/></td>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '</tr>');

            //$("div.quiz-question-row").on("click","a#new-question-button",clickedNewQuestionButton);

            function clickedNewQuestionButton(e) {
                if (!$("#new-quiz-question-form").length) {
                    $("div.quiz-question-row").find("table").append(quizQuestionFormTemplate({
                        formID: 'new-quiz-question-form'
                    }));
                }
            }

        </script>
    </div>
</div>
