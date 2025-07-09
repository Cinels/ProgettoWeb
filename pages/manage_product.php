<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Gestisci Prodotto";
$templateParams["main_content"] = ["user/manage_product.php"];
$templateParams['css'] = [CSS_DIR."style.css"];
require("../template/base.php")
?>