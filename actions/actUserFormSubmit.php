<?php
if (isset($_POST['submit'])) {
    d($_POST);

} else {
    header("location: $root/index.php?action=manageUsers");
    exit;
}





