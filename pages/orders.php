<?php
require_once("../database/init.php");
$templateParams["titolo"] = "I tuoi Ordini";
$templateParams['js'] = [JAVASCRIPT_DIR."orders.js"];
$templateParams['css'] = [CSS_DIR."base.css", CSS_DIR."main.css"];
checkLogin($dbh);
require("../template/base.php")
?>