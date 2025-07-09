<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Risultati";
$templateParams['js'] = [JAVASCRIPT_DIR.'results.js'];

if(!isset($_GET["search"])) {
    header('Location:'.PAGES_DIR."index.php");    
}

require("../template/base.php")
?>