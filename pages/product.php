<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Errore";
// $templateParams["main_content"] = ["product.php"];
$templateParams['js'] = [JAVASCRIPT_DIR.'product.js'];

if(isset($_GET["search"])) {
    $templateParams["titolo"] = $dbh->getProduct($_GET["search"])[0]['nome'];
    $templateParams["subtitles"] = ["Correlati"];
    $templateParams["side_content"] = [$dbh->getRelatedProducts($_GET["search"], 10)];
} else {
    header('Location:'.PAGES_DIR."index.php");    
}

require("../template/base.php")
?>