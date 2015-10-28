<?php
include "models/quiz.php";
$connection = mysqli_connect("localhost", "php", "password");
if (!$connection) {
    $errorMsg = "no connection";
} else { //connection was good
    $db = mysqli_select_db($connection, "DB_PHP");
    $queryString = "SELECT * FROM QUIZ;";
    $getQuizzes = mysqli_query($connection, $queryString);
    $quizList = array();
    if (is_bool($getQuizzes) && !$getQuizzes) {
        $errorMsg = "bad query";
    } else {
        $getQuizzes->fetch_array();
        foreach ($getQuizzes as $quizThing) {
            array_push($quizList, (new quiz())->populateFromQuery($quizThing));
        }
    }
}

mysqli_close($connection); // Closing Connection
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
                            <th>
                                Name
                            </th>
                            <th style=\"width:250px;\">
                                Description
                            </th>
                            <th style=\"width:50px;\">
                                &nbsp;<!--active-->
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

                echo "</tr>";
            }

            echo "</tbody>
                </table>
            ";
        }

        ?>
    </div>
</div>
