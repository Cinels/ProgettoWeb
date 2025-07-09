<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Lista Preferiti";
$templateParams["js"] = [JAVASCRIPT_DIR."favourite.js", JAVASCRIPT_DIR.'suggestions.js'];

checkLogin($dbh);

require("../template/base.php")
?>