<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Profilo";
$templateParams["main_content"] = ["user/profile.php", "user/notifications.php"];

if(isset($_GET["logout"])) {
    $dbh->logout();
    header('Location:'.PAGES_DIR."index.php");
}

require("../template/base.php")
?>