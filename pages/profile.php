<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Profilo";
$templateParams["main_content"] = ["user/profile.php", "user/notifications.php"];
$templateParams["user"] = $dbh->getUser();
if ($dbh->getUserType() == "client") {
    $templateParams["user_type"] = "Cliente";
} else {
    $templateParams["user_type"] = "Venditore";
}
$templateParams["notifications"] = $dbh->getNotifications();

if(!$dbh->isLogged()) {
    header("location: login.php");
}

if(isset($_GET["logout"])) {
    $dbh->logout();
    header('Location:'.PAGES_DIR."index.php");
}

require("../template/base.php")
?>