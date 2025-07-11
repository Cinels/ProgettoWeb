<?php
require_once("../database/init.php");
$templateParams["titolo"] = "I tuoi prodotti";
$templateParams['js'] = [JAVASCRIPT_DIR.'vendor_products.js'];
$templateParams['css'] = [CSS_DIR."base.css", CSS_DIR."main.css"];
require("../template/base.php")
?>