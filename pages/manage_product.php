<?php
require_once("../database/init.php");
$templateParams["titolo"] = isset($_GET['id']) ? "Modifica Prodotto" : "Inserisci Prodotto" ;
$templateParams['js'] = [JAVASCRIPT_DIR."manage_product.js"];
$templateParams['css'] = [CSS_DIR."base.css", CSS_DIR."style.css"];
require("../template/base.php");
?>