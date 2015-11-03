<?php
ob_start();
//ini_set('display_errors',1);
//error_reporting(-1);

if(!isset($_SESSION)) {session_start();} //checking if session needs to be started
if(!isset($_SESSION['loggedIn'])) {$_SESSION['loggedIn']=false;} //checking if session loggedIn has been set yet
if(!isset($_SESSION['loggedInUserID'])) {$_SESSION['loggedInUserID']=0;} //checking if loggedIn userid has been set yet
$root = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://'.$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
//this file acts as a controller, including pages that are necessary
$activeNavTab='login';
if (!isset($_GET["action"])) {
    $toInclude = ['views/login.php'];
    $pageTitle='Log In';
    $activeNavTab='login';
    $securedPage=false;
} else {
    $securedPage=true; //pages are security (loggedIn = true) checked by default and explicitly stated if not
    switch($_GET["action"]) {
        case "login": $toInclude = ['views/login.php']; $pageTitle='Log In'; $activeNavTab = "login";  $securedPage=false; break;
        case "logout": $toInclude = ['actions/logout.php'];  $pageTitle='Log Out' ; $securedPage=false ;break;
        case "manageUsers": $toInclude = ['includes/securityCheck_userSection.php','views/manageUsers.php']; $pageTitle='Manage Users'; $activeNavTab = "userManage";  break;
        case "userDetail": $toInclude = ['includes/securityCheck_userSection.php','views/userDetail.php']; $pageTitle='User Detail'; $activeNavTab = "userManage";  break;
        case "userForm": $toInclude = ['includes/securityCheck_userSection.php','views/userForm.php']; $pageTitle='User Form'; $activeNavTab = "userManage";  break;
        case "actUserFormSubmit": $toInclude = ['includes/securityCheck_quizManageSection.php','actions/actUserFormSubmit.php']; $pageTitle='User Form';  break;
        case "manageQuiz": $toInclude = ['includes/securityCheck_quizManageSection.php','views/manageQuiz.php']; $pageTitle='Manage Quizzes'; $activeNavTab = "manageQuiz";  break;
        case "quizDetail": $toInclude = ['includes/securityCheck_quizManageSection.php','views/quizDetail.php']; $pageTitle='Quiz Detail'; $activeNavTab = "manageQuiz";  break;
        case "quizForm": $toInclude = ['includes/securityCheck_quizManageSection.php','views/quizForm.php']; $pageTitle='Quiz Form'; $activeNavTab = "manageQuiz";  break;
        case "actQuizFormSubmit": $toInclude = ['includes/securityCheck_quizManageSection.php','actions/actQuizFormSubmit.php']; $pageTitle='Quiz Form';  break;
        case "quizList": $toInclude = ['includes/securityCheck_quizSection.php','views/quizList.php']; $pageTitle='View Quizzes'; $activeNavTab = "quizList";  break;
        case "quizTake": $toInclude = ['includes/securityCheck_quizSection.php','views/quizTake.php']; $pageTitle='Taking Quiz'; $activeNavTab = "quizList";  break;
        case "actQuizSubmit": $toInclude = ['includes/securityCheck_quizSection.php','actions/actQuizSubmit.php']; break;
        case "quizResults": $toInclude = ['includes/securityCheck_quizSection.php','views/quizResults.php']; $pageTitle='Quiz Results'; $activeNavTab = "quizResults";  break;
        case "userResults": $toInclude = ['includes/securityCheck_quizManageSection.php','views/userResults.php']; $pageTitle='User Quiz Results'; $activeNavTab = "userResults";  break;
        default: $toInclude = ['views/login.php']; $pageTitle='Log In'; $activeNavTab = "login";
    }
}

include_once 'assets/kint/Kint.class.php';
include_once "includes/helperFunctions.php";
if ($securedPage) {
    include_once "includes/securityCheck.php";
}
include_once "models/user.php"; //included for displaying name on the nav
?>

<html>
    <head>
        <title><?php echo $pageTitle; ?></title>
        <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="./assets/css/main.css" rel="stylesheet">
        <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon">
        <script src="./assets/js/jquery.min.js"></script>
        <script src="./assets/js/lodash_3.10.1.min.js"></script>
        <script src="./assets/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php include_once "includes/navbar.php"; ?>
        <div class="container">
            <?php
                foreach($toInclude as $singleInclude) {
                    include_once($singleInclude);
                }
            ?>
        </div>
    </body>
</html>
<?php ob_end_flush(); /*end output buffering and send our HTML to the browser as a whole*/ ?>