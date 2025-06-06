<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Il Puzzo";
$templateParams["main_content"] = ["home.php"];
if(!($dbh->isLogged() && $dbh->getUserType() == "vendor")) {
    $templateParams["subtitles"] = ["In Sconto", "Tendenze", "I tuoi Interessi"];
    $templateParams["side_content"] = [$dbh->getProductsOnSale(10), $dbh->getTrendProducts(10), $dbh->getYourInterestProducts(10)];
}

require("../template/base.php");
?>