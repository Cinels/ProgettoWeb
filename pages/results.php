<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Risultati";
$templateParams['js'] = [JAVASCRIPT_DIR.'results.js'];
$templateParams['css'] = [CSS_DIR."base.css", CSS_DIR."style.css"];
if(!isset($_GET["search"])) {
    header('Location:'.PAGES_DIR."index.php");    
}
require("../template/base.php")
?>