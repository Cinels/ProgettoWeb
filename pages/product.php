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

if(isset($_GET["cart"])) {
    $dbh->addToCart($_GET["search"], $_GET["cart"]);
}

//Implementare questa parte in JavaScript
if(isset($_GET["favourites"])) {
    if($_GET["favourites"] === "add") {
        $dbh->addToFavourites($_GET["search"]);
    } elseif($_GET["favourites"] === "remove") {
        $dbh->removeFromFavourites($_GET["search"]);
    }
}

require("../template/base.php")
?>