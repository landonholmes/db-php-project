<?php
if (isset($_POST['submit'])) {
    d($_POST);

} else {
    $root = $_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("location: $root/index.php?action=manageUsers");
    exit;
}





