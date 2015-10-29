<?php
include_once "models/quiz.php";

$quizList = (new quiz())->loadAll();
?>

<div class="row">
    <h1>Managing Quizzes<a href="index.php?action=quizForm&quizID=0" class="btn btn-info" style="float:right;margin-top:5px;">New</a></h1>

    <?php if (isset($errorMsg)){echo "<label class=\"label label-warning\">$errorMsg</label>";}?>
    <div class="col-sm-12">
        <?php if(count($quizList) < 1) {
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
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>";

            foreach ($quizList as $singleQuiz) {
                echo "<tr>
                        <td>
                            <a href=\"index.php?action=quizDetail&quizID=$singleQuiz->QuizID\">$singleQuiz->Name</a>
                        </td>
                        <td>
                            <a href=\"index.php?action=quizDetail&quizID=$singleQuiz->QuizID\">$singleQuiz->Description</a>
                        </td>
                        <td style=\"text-align:center;\">
                        ";

                if ($singleQuiz->IsActive == 0) {
                    echo "<span class=\"label label-warning\">Disabled</span>";
                } else {
                    echo "<span class=\"label label-info\">Active</span>";
                }

                echo "</td></tr>";
            }

            echo "</tbody>
                </table>
            ";
        }

        ?>
    </div>
</div>
