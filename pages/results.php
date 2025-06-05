<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Risultati";
$templateParams["main_content"] = ["results.php"];
if(!($dbh->isLogged() && $dbh->getUserType() == "vendor")) {
    $templateParams["side_content"] = [$dbh->getProductsOnSale(10), $dbh->getTrendProducts(10), $dbh->getYourInterestProducts(10)];
}

if(isset($_GET["search"])) {
    $templateParams["results"] = $dbh->getProductsFromResearch($_GET["search"]);
}

require("../template/base.php")
?>