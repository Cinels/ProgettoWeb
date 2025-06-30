<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Prodotto";
$templateParams["main_content"] = ["product.php"];

if(isset($_GET["search"])) {
    $templateParams["results"] = $dbh->getProduct($_GET["search"]);
    $dbh->updateHistory($_GET["search"]);
    $templateParams["images"] = $dbh->getProductImages($_GET["search"]);
    $templateParams["subtitles"] = ["Correlati"];
    $templateParams["side_content"] = [$dbh->getRelatedProducts($_GET["search"], 10)];
} else {
    header('Location:'.PAGES_DIR."index.php");    
}

//Implementare questa parte in JavaScript
if(isset($_POST["cart"])) {
    checkClientLogin($dbh);
    $dbh->addToCart($_GET["search"], $_POST["cart"]);
    header("Location: ".PAGES_DIR."product.php?search=".$_GET["search"]);
}

//Implementare questa parte in JavaScript PEFFOH
if(isset($_GET["favourites"])) {
    checkClientLogin($dbh);
    if($_GET["favourites"] === "add" && !$dbh->isProductFavourite($_GET["search"])) {
        $dbh->addToFavourites($_GET["search"]);
    } elseif($_GET["favourites"] === "remove" && $dbh->isProductFavourite($_GET["search"])) {
        $dbh->removeFromFavourites($_GET["search"]);
    }
}

function checkClientLogin($dbh) {
    checkLogin($dbh);
    if($dbh->isLogged() && $dbh->getUserType() == "vendor") {
        header("location: profile.php");
        exit();
    }
}

require("../template/base.php")
?>