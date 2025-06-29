<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Carrello";
$templateParams["main_content"] = ["user/cart.php"];
$templateParams["subtitles"] = ["I tuoi Interessi"];
$templateParams["side_content"] = [$dbh->getYourInterestProducts(10)];

$templateParams['results'] = $dbh->getCart();

if(!$dbh->isLogged()) {
    header("location: login.php");
}

if(isset($_GET["favourite"])) {
    $dbh->moveToFavourites($_GET["id"]);
}

if(isset($_GET["remove"])) {
    $dbh->removeFromCart($_GET["id"]);
}

require("../template/base.php")
?>