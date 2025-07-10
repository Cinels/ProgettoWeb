<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Profilo";
$templateParams['js'] = [JAVASCRIPT_DIR.'profile.js'];
$templateParams['css'] = [CSS_DIR."base.css", CSS_DIR."style.css"];
checkLogin($dbh);
require("../template/base.php");
?>