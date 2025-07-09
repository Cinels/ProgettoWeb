<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Accedi";
$templateParams["js"] = [JAVASCRIPT_DIR."login.js"];

require("../template/base.php")
?>