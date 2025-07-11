<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Accedi";
$templateParams["js"] = [JAVASCRIPT_DIR."login.js"];
$templateParams['css'] = [CSS_DIR."base.css", CSS_DIR."main.css"];
require("../template/base.php")
?>