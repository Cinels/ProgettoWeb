<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Prodotto";
$templateParams["main_content"] = ["product.php"];

if(isset($_GET["search"])) {
    $templateParams["results"] = $dbh->getProduct($_GET["search"]);
    $templateParams["images"] = $dbh->getProductImages($_GET["search"]);
    $templateParams["subtitles"] = ["Correlati"];
    $templateParams["side_content"] = [$dbh->getRelatedProducts($_GET["search"], 10)];
}

require("../template/base.php")
?>