<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Carrello";
$templateParams["main_content"] = ["user/cart.php"];
$templateParams["subtitles"] = ["I tuoi Interessi"];
$templateParams["side_content"] = [$dbh->getYourInterestProducts(10)];

$templateParams['results'] = $dbh->getCart();

checkLogin($dbh);

if(isset($_GET["favourite"])) {
    $dbh->moveToFavourites($_GET["id"]);
}

if(isset($_GET["remove"])) {
    $dbh->removeFromCart($_GET["id"]);
}

require("../template/base.php")
?>