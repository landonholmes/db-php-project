<?php
include "models/quiz.php";
if (isset($_GET["quizID"])) {
    $quizID = $_GET["quizID"];
} else {
    //we didn't get an id. abort
    redirect("$root/index.php?action=manageQuiz");
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
    <div class="col-sm-12">
        <h2>Quiz Form</h2>
    </div>
</div>

<div class="row">
    <form class="form-horizontal" action="index.php?action=actQuizFormSubmit" method="POST">
        <div class="form-group">
            <label class="control-label col-sm-2 label-required" for="name">Name:</label>
            <div class="col-sm-5">
                <input type="text" id="name" name="name" class="form-control" required value="<?php print $quiz->Name;?>" />
                <!--error message?-->
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2 label-required" for="description">Description:</label>
            <div class="col-sm-5">
                <input type="text" id="description" name="description" class="form-control" required value="<?php print $quiz->Description;?>" />
                <!--error message?-->
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2 label-required" for="isActive">Disabled?</label>
            <div class="col-sm-5">
                <select id="isActive" name="isActive" class="form-control" required>
                    <option value="1" <?php if($quiz->IsActive==1) {echo "selected";} ?>>Active</option>
                    <option value="0" <?php if($quiz->IsActive==0) {echo "selected";} ?>>Disabled</option>
                </select>
                <!--error message?-->
            </div>
        </div>

        <div class="col-sm-offset-1 col-sm-6 well">
            <input type="hidden" name="lastModifiedBy" value="<?php print $_SESSION['loggedInUserID'];?>" />
            <input type="hidden" name="quizID" value="<?php print $quiz->QuizID;?>" />
            <input type="submit" value="Submit" name="submit" class="btn btn-primary" id="accountSubmitButton" />
        </div>
    </form>

    <script>
        var PAGE = {
            quizID: <?php print $quiz->QuizID;?>,
            xeh: {
                ajaxIsQuizNameAvailable: '',
            };
    </script>
</div>
