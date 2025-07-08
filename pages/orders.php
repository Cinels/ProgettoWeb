<?php
require_once("../database/init.php");
$templateParams["titolo"] = "I tuoi Ordini";
$templateParams['js'] = [JAVASCRIPT_DIR."orders.js"];

checkLogin($dbh);

require("../template/base.php")
?>