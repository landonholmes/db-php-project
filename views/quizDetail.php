<?php
include "models/quiz.php";
if (isset($_GET["quizID"])) {
    $quizID = $_GET["quizID"];
} else {
    //we didn't get an id. abort
    redirect("$root/index.php?action=manageUsers");
}
$connection = mysqli_connect("localhost", "php", "password");
if (!$connection) {
    //error connecting
} else { //connection was good
    $db = mysqli_select_db($connection, "DB_PHP");
    $queryString = "SELECT * FROM QUIZ WHERE QuizID = '$quizID';";
    $getQuiz = mysqli_query($connection, $queryString);
    $getQuiz = $getQuiz->fetch_array();
    $quiz = (new quiz())->populateFromQuery($getQuiz);
}
mysqli_close($connection); // Closing Connection

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
</div>
