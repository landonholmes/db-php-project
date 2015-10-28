<?php
if (isset($_POST['submit'])) {
    d($_POST);

} else {
    redirect("$root/index.php?action=manageUsers");
}





