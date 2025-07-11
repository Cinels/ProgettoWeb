<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Pagamento";
$templateParams['js'] = [JAVASCRIPT_DIR.'payment.js'];
$templateParams['css'] = [CSS_DIR."base.css", CSS_DIR."main.css"];
require("../template/base.php")
?>