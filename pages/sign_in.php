<?php
require_once("../database/init.php");
$templateParams["titolo"] = ((isset($_GET['action']) && $_GET['action'] === 'edit') ? "Modifica Profilo" : "Registrati");
$templateParams['js'] = [JAVASCRIPT_DIR.'sign_in.js'];
$templateParams['css'] = [CSS_DIR."base.css", CSS_DIR."main.css"];
require("../template/base.php")
?>