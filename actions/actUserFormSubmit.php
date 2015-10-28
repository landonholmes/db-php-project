<?php
if (isset($_POST['submit'])) {
    d($_POST);

} else {
    header("location: ./../index.php?action=manageUsers");
    exit;
}





