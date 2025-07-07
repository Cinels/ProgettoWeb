<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Profilo";
// $templateParams["main_content"] = ["user/profile.php", "user/notifications.php"];
// $templateParams["user"] = $dbh->getUser();
// $templateParams['user_type'] = $dbh->getUserType() === "client" ? 'Cliente' : 'Venditore';
// $templateParams["notifications"] = $dbh->getNotifications();
$templateParams['js'] = [JAVASCRIPT_DIR.'profile.js'];

checkLogin($dbh);

require("../template/base.php");
?>