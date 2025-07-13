<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Home";
$templateParams["js"] = [JAVASCRIPT_DIR."home.js", JAVASCRIPT_DIR."suggestions.js"];
$templateParams['css'] = [CSS_DIR."base.css", CSS_DIR."aside.css", CSS_DIR."main.css"];
if($dbh->isLogged() && $dbh->getUserType() === "vendor") {
    header('location: vendor_products.php');
}
require("../template/base.php");
?>