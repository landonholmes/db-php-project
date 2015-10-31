<?php
include_once "models/quiz.php";
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
                <a href=\"index.php?action=quizForm&quizID=$quizID\" class=\"btn btn-default\">Update Quiz</a>
            </div>
        </div>";
        ?>
</div>
<br />
<div class="row">
    <div class="col-sm-12">
        Edit questions for quiz below. <br /><span style="font-weight: bold;">Please note:</span> Quizzes with no questions are not shown on the available quiz list. Questions with no options are not shown or graded for when taking the quiz.
    </div>
</div>
<div class="row quiz-question-row">
    <div class="col-sm-12">
        <h2>Questions:<a class="btn btn-sm btn-info" id="new-question-button" style="float:right;margin-top:5px;">New Question</a></h2>
        <table class="table table-condensed table-detail">
            <tr>
                <th style="width:37%;">Text</th>
                <th style="width:10%;">Type</th>
                <th style="width:10%;">Status</th>
                <th style="width:30%;">Options (<span style="font-weight:bold;text-decoration:underline;">answer</span>)</th>
                <th style="width:25%;">&nbsp;</th>
            </tr>
            <?php
                foreach ($quiz->Quiz_Questions as $quizQuestion) {
                    echo "
                    <tr data-question-id=\"$quizQuestion->QuestionID\">
                        <td class=\"textValue\">$quizQuestion->Text</td>
                        <td class=\"typeValue\">$quizQuestion->Type</td>
                        <td class=\"isActiveValue\" data-isActive=\"$quizQuestion->IsActive\">";
                    if ($quizQuestion->IsActive == 0) {
                        echo "<span class=\"label label-warning\">Locked</span>";
                    } else {
                        echo "<span class=\"label label-info\">Active</span>";
                    }
                    echo "</td>
                        <td class=\"optionValue\">";
                        echo "<ul class=\"optionUL\">";
                        foreach ($quizQuestion->Options as $quizQuestionOption) {
                            echo "<li class=\"optionItem input-group\" data-option-id=\"$quizQuestionOption->QuestionOptionID\"><span class=\"form-control optionText\"";
                            if ($quizQuestionOption->IsAnswer == 1) {
                                echo " style=\"font-weight:bold; text-decoration:underline;\"";
                            }
                            echo ">$quizQuestionOption->Text</span>
                                <div class=\"input-group-addon toggleIsAnswer\"><i class=\"glyphicon glyphicon-check icon-white\"></i></div>
                                <div class=\"input-group-addon deleteOption\"><i class=\"glyphicon glyphicon-remove icon-white\"></i></div>
                            </li>";
                        }
                        echo "<li class=\"optionItem input-group\"><input class=\"form-control\" name=\"optionText\" placeholder=\"New Option\"><div class=\"input-group-addon addOption\"><i class=\"glyphicon glyphicon-plus icon-white\"></i></div></li>
                            </ul>";
                    echo "</td>
                        <td>
                            <button class=\"btn btn-sm btn-info edit-question-button\" data->Edit</button>&nbsp;";
                        if ($quizQuestion->IsActive == 0) {
                            echo "<button class=\"btn btn-sm btn-success enable-question-button\">Enable</button>";
                            } else {
                            echo "<button class=\"btn btn-sm btn-danger disable-question-button\">Disable</button>";
                            }
                    echo "</td>
                    </tr>
                    ";
                }
            ?>
        </table>
        <script>
            var PAGE = {
                quizID: <?php print($quiz->QuizID); ?>
                ,editing: {}
            };
            var quizQuestionRowTemplate = _.template('<tr data-question-id="<%= questionID %>">' +
                    '<td class="textValue"><%= text %></td>' +
                    '<td class="typeValue"><%= type %></td>' + //type
                    '<td class="isActiveValue" data-isActive="<%= isActive %>">' +
                        '<% if (isActive == 0) {%> <span class=\"label label-warning\">Locked</span> <%}else{%><span class=\"label label-info\">Active</span> <%}%> ' +
                    '</td>' + //status
                    '<td class="optionValue">' +
                        '' +
                    '</td>' + //cancel
                    '<td>' +
                        '<button class="btn btn-sm btn-info edit-question-button" data->Edit</button>&nbsp;' +
                        '<% if (isActive == 0) {%> <button class=\"btn btn-sm btn-success enable-question-button\">Enable</button> <%}else{%><button class=\"btn btn-sm btn-danger disable-question-button\">Disable</button> <%}%> ' +
                        '</td>' + //cancel/submit
                '</tr>');
            var quizQuestionFormTemplate = _.template('<tr class="quiz-question-form" id="<%= formID %>">' +
                    '<td><input type="text" class="form-control" name="text" value="<%= text %>"/></td>' +
                    '<td><select class="form-control" name="type">' +
                        '<option value="Select" <% if(type=="Select"){%>selected<%}%>>Select</option>' +
                        '<option value="Text" <% if(type=="Text"){%>selected<%}%>>Text</option>' +
                    '</select></td>' + //type
                    '<td><select class="form-control" name="isActive">' +
                        '<option value="1" <% if(type==1){%>selected<%}%>>Active</option>' +
                        '<option value="0" <% if(type==0){%>selected<%}%>>Disabled</option>' +
                    '</select></td>' +
                    '<td></td>' +
                    '<td><button class="btn btn-sm btn-danger cancel-<%=formType%>-button">Cancel</button>&nbsp;<button class="btn btn-sm btn-success submit-<%=formType%>-button">Submit</button></td>' + //cancel/submit
                '</tr>');
            var quizQuestionOptionListItemTemplate = _.template('<li class="optionItem input-group" data-option-id="<%= optionID %>">' +
                    '<span class="form-control optionText" <% if(isAnswer == 1) {%>style="font-weight:bold; text-decoration:underline;"<%}%> ><%= text %></span>' +
                    '<div class="input-group-addon toggleIsAnswer"><i class="glyphicon glyphicon-check icon-white"></i></div><div class="input-group-addon deleteOption"><i class="glyphicon glyphicon-remove icon-white"></i></div></li>');

            $("div.quiz-question-row").on("click","a#new-question-button",clickedNewQuestionAddButton);
            $("div.quiz-question-row").on("click","button.cancel-add-button",newQuestionCancel);
            $("div.quiz-question-row").on("click","button.submit-add-button",newQuestionSubmit);
            $("div.quiz-question-row").on("click","button.edit-question-button",clickedEditQuestionButton);
            $("div.quiz-question-row").on("click","button.cancel-edit-button",editQuestionCancel);
            $("div.quiz-question-row").on("click","button.submit-edit-button",editQuestionSubmit);
            $("div.quiz-question-row").on("click","button.enable-question-button",disableEnableQuizQuestion);
            $("div.quiz-question-row").on("click","button.disable-question-button",disableEnableQuizQuestion);
            $("ul.optionUL").on("click","div.toggleIsAnswer",toggleIsAnswerForOption);
            $("ul.optionUL").on("click","div.deleteOption",deleteOption);
            $("ul.optionUL").on("click","div.addOption",addOption);
            //add option to question
            //remove option from question

            function clickedNewQuestionAddButton(e) {
                if (!$("#new-quiz-question-form").length) {
                    $("div.quiz-question-row").find("table").append(quizQuestionFormTemplate({
                        formID: 'new-quiz-question-form'
                        ,text: ''
                        ,type: 'Select'
                        ,isActive: '1'
                        ,formType: 'add'
                    })).find("input[name=text]").focus();
                }
            }

            function newQuestionSubmit() {
                //get information from inputs
                var thisFormRow = $(this).parents("td").parents("tr");
                var text = thisFormRow.find("input[name=text]").val();
                var type = thisFormRow.find("select[name=type] option:selected").val();
                var isActive = thisFormRow.find("select[name=isActive] option:selected").val();

                $.ajax( {
                    "dataType": 'json',
                    "type": 'POST',
                    "url": "includes/helperFunctions.php",
                    "data": {"action":"addQuestionToQuiz","QuizID":PAGE.quizID,"Text":text,"Type":type,"IsActive":isActive},
                    "success": function(e) { //tries to return the new question id
                        console.log("success",e);
                        if(e === +e){
                            $("div.quiz-question-row").find("table").append(quizQuestionRowTemplate({
                                questionID: e
                                ,text: text
                                ,type: type
                                ,isActive: isActive
                            }));
                            thisFormRow.remove();
                        }
                    },
                    "timeout": 15000,
                    "error": function(e) {
                        console.log("error",e);
                    }
                });
            }

            function clickedEditQuestionButton(e) {
                var thisRow = $(this).parents("td").parents("tr");
                var quizQuestionID = thisRow.attr("data-question-id");
                var text = thisRow.children(".textValue").html();
                var type = thisRow.children(".typeValue").html();
                var isActive = thisRow.children(".isActiveValue").attr("data-isActive");

                PAGE.editing[quizQuestionID] = thisRow;

                thisRow.replaceWith(quizQuestionFormTemplate({
                    formID: quizQuestionID
                    ,text: text
                    ,type: type
                    ,isActive: isActive
                    ,formType: 'edit'
                })).find("input[name=text]").focus();
            }
            
            function newQuestionCancel() {$("#new-quiz-question-form").remove();}

            function editQuestionCancel() {
                var thisRow = $(this).parents("td").parents("tr");
                var quizQuestionID = thisRow.attr("id");
                thisRow.replaceWith(PAGE.editing[quizQuestionID])
            }

            function editQuestionSubmit() {
                //get information from inputs
                var thisFormRow = $(this).parents("td").parents("tr");
                var quizQuestionID = thisFormRow.attr("id");
                var text = thisFormRow.find("input[name=text]").val();
                var type = thisFormRow.find("select[name=type] option:selected").val();
                var isActive = thisFormRow.find("select[name=isActive] option:selected").val();

                $.ajax( {
                    "dataType": 'json',
                    "type": 'POST',
                    "url": "includes/helperFunctions.php",
                    "data": {"action":"editQuestion","QuestionID":quizQuestionID,"Text":text,"Type":type,"IsActive":isActive},
                    "success": function(e) { //tries to return the new question id
                        console.log("success",e);
                        if(e === +e){
                            thisFormRow.replaceWith(quizQuestionRowTemplate({
                                questionID: e
                                ,text: text
                                ,type: type
                                ,isActive: isActive
                            }));
                            thisFormRow.remove();
                        }
                    },
                    "timeout": 15000,
                    "error": function(e) {
                        console.log("error",e);
                    }
                });
            }



            function disableEnableQuizQuestion() {
                var thisRow = $(this).parents("td").parents("tr");
                var quizQuestionID = thisRow.attr("data-question-id");
                var text = thisRow.children(".textValue").html();
                var type = thisRow.children(".typeValue").html();
                var isActive = thisRow.children(".isActiveValue").attr("data-isActive");
                var newActiveValue = isActive ^= 1;

                $.ajax( {
                    "dataType": 'json',
                    "type": 'POST',
                    "url": "includes/helperFunctions.php",
                    "data": {"action":"disableEnableQuizQuestion","QuestionID":quizQuestionID,"IsActive":newActiveValue},
                    "success": function(e) { //tries to return the new question id
                        console.log("success",e);
                        if(e == 1 || e == 0){
                            thisRow.replaceWith(quizQuestionRowTemplate({
                                questionID: quizQuestionID
                                ,text: text
                                ,type: type
                                ,isActive: e
                            }));
                        }
                    },
                    "timeout": 15000,
                    "error": function(e) {
                        console.log("error",e);
                    }
                });
            }

            function toggleIsAnswerForOption() {
                var thisRow = $(this).parents("li.optionItem");
                var quizQuestionOptionID = thisRow.attr("data-option-id");
                var text = thisRow.children("span.optionText").text();

                $.ajax( {
                    "dataType": 'json',
                    "type": 'POST',
                    "url": "includes/helperFunctions.php",
                    "data": {"action":"toggleIsAnswerForOption","QuestionOptionID":quizQuestionOptionID},
                    "success": function(e) { //tries to return the new status
                        console.log("success",e);
                        if(e == 1 || e == 0){
                            thisRow.replaceWith(quizQuestionOptionListItemTemplate({
                                optionID: quizQuestionOptionID
                                ,text: text
                                ,isAnswer: e
                            }));
                        }
                    },
                    "timeout": 15000,
                    "error": function(e) {
                        console.log("error",e);
                    }
                });
            }

            function deleteOption() {
                var thisRow = $(this).parents("li.optionItem");
                var quizQuestionOptionID = thisRow.attr("data-option-id");

                $.ajax( {
                    "dataType": 'json',
                    "type": 'POST',
                    "url": "includes/helperFunctions.php",
                    "data": {"action":"deleteOption","QuestionOptionID":quizQuestionOptionID},
                    "success": function(e) { //tries to return result
                        console.log("success",e);
                        if(e == 1){
                            thisRow.remove();
                        }
                    },
                    "timeout": 15000,
                    "error": function(e) {
                        console.log("error",e);
                    }
                });
            }

            function addOption() {
                var thisRow = $(this).parents("li.optionItem");
                var quizQuestionID = thisRow.parents("ul").parents("td.optionValue").parents("tr").attr("data-question-id");
                var quizQuestionOptionText = thisRow.find("input[name=optionText]").val();

                if (quizQuestionOptionText.length) {
                    $.ajax({
                        "dataType": 'json',
                        "type": 'POST',
                        "url": "includes/helperFunctions.php",
                        "data": {"action": "addOption", "QuestionID": quizQuestionID, "Text": quizQuestionOptionText},
                        "success": function (e) { //tries to return the new question id
                            console.log("success", e);
                            if (e === +e) {
                                thisRow.before(quizQuestionOptionListItemTemplate({
                                    optionID: e
                                    ,text: quizQuestionOptionText
                                    ,isAnswer: 0
                                }));
                            }
                        },
                        "timeout": 15000,
                        "error": function (e) {
                            console.log("error", e);
                        }
                    });
                }
            }

        </script>
    </div>
</div>
