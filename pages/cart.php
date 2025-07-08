<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Carrello";
$templateParams["js"] = [JAVASCRIPT_DIR."cart.js", JAVASCRIPT_DIR.'suggestions.js'];

checkLogin($dbh);

require("../template/base.php")
?>