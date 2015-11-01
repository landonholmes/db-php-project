<?php
include_once "models/quiz.php";

$quizList = (new quiz())->loadAllActive();

$quizQuestionCount = 0; //this is to check to make sure at least one quiz actually has questions before it shows any
foreach ($quizList as $singleQuiz) {
    $quizQuestionCount+=(count($singleQuiz->Questions));
}
?>

<div class="row">
    <h1>Available Quizzes</h1>

    <?php if (isset($errorMsg)){echo "<label class=\"label label-warning\">$errorMsg</label>";}?>
    <div class="col-sm-12">
        <?php if(count($quizList) < 1 || $quizQuestionCount == 0) {
            echo 'No quizzes found..';
        } else {
            echo "
                <table class=\"table table-condensed table-bordered\">
                    <thead>
                        <tr>
                            <th style=\"width:20%;\">
                                Name
                            </th>
                            <th style=\"width:70%;\">
                                Description
                            </th>
                            <th style=\"width:10%;\">
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>";

            foreach ($quizList as $singleQuiz) {
                echo "<tr>
                        <td>
                            $singleQuiz->Name
                        </td>
                        <td>
                            $singleQuiz->Description
                        </td>
                        <td style=\"text-align:center;\">
                             <a href=\"index.php?action=quizTake&quizID=$singleQuiz->QuizID\">Take Quiz</a>
                        </td>
                    </tr>";
            }

            echo "</tbody>
                </table>
            ";
        }

        ?>
    </div>
</div>
