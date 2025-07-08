<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Risultati";
$templateParams["main_content"] = ["results.php"];

if(isset($_GET["search"])) {
    $templateParams["results"] = $dbh->getProductsFromResearch($_GET["search"]);
}
else if(!($dbh->isLogged() && $dbh->getUserType() == "vendor")) {
    $templateParams["subtitles"] = ["In Sconto", "Tendenze", "I tuoi Interessi"];
    $templateParams["side_content"] = [$dbh->getProductsOnSale(10), $dbh->getTrendProducts(10), $dbh->getYourInterestProducts(10)];
}

if(isset($_GET["cart"]) && isset($_GET["id"])) {
    if($_GET["cart"] === "add") {
        $dbh->addToCart($_GET["id"], 1);
    } elseif($_GET["cart"] === "remove") {
        $dbh->removeFromCart($_GET["id"], $dbh->getUser()['email']);
    }
}

if(isset($_GET["favourites"]) && isset($_GET["id"])) {
    if($_GET["favourites"] === "add") {
        $dbh->addToFavourites($_GET["id"], $dbh->getUser()['email']);
    } elseif($_GET["favourites"] === "remove") {
        $dbh->removeFromFavourites($_GET["id"]);
    }
}

require("../template/base.php")
?>