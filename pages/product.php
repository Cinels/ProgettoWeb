<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Errore";
$templateParams['js'] = [JAVASCRIPT_DIR.'product.js', JAVASCRIPT_DIR.'suggestions.js'];
$templateParams['css'] = [CSS_DIR."base.css", CSS_DIR."aside.css", CSS_DIR."main.css"];
if(isset($_GET["search"])) {
    $templateParams["titolo"] = $dbh->getProduct($_GET["search"])[0]['nome'];
} else {
    header('Location:'.PAGES_DIR."index.php");    
}
require("../template/base.php")
?>