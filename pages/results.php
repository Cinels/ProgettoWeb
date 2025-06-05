<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Risultati";
$templateParams["main_content"] = ["results.php"];
if(!($dbh->isLogged() && $dbh->getUserType() == "vendor")) {
    $templateParams["side_content"] = [$dbh->getProductsOnSale(10), $dbh->getTrendProducts(10), $dbh->getYourInterestProducts(10)];
}

$templateParams["results"] = ["ciao", "come", "stai"];

require("../template/base.php")
?>