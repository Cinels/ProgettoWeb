<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Carrello";
$templateParams["js"] = [JAVASCRIPT_DIR."cart.js", JAVASCRIPT_DIR.'suggestions.js'];
$templateParams['css'] = [CSS_DIR."base.css", CSS_DIR."aside.css", CSS_DIR."main.css"];
checkLogin($dbh);
require("../template/base.php")
?>