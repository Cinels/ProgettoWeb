<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Accedi";
// $templateParams["main_content"] = ["login.php"];
$templateParams["js"] = [JAVASCRIPT_DIR."login.js"];

require("../template/base.php")
?>