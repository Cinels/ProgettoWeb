<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Profilo";
$templateParams["main_content"] = ["user/profile.php", "user/notifications.php"];

require("../template/base.php")
?>