<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Profilo";
$templateParams['js'] = [JAVASCRIPT_DIR.'profile.js'];

checkLogin($dbh);

require("../template/base.php");
?>