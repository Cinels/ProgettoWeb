<?php
require_once("../database/init.php");
$templateParams["titolo"] = "I tuoi Ordini";
$templateParams['js'] = [JAVASCRIPT_DIR."orders.js"];
$templateParams['css'] = [CSS_DIR."style.css"];
checkLogin($dbh);
require("../template/base.php")
?>