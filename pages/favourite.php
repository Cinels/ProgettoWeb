<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Lista Preferiti";

// $templateParams["main_content"] = ["user/favourites.php"];
$templateParams["subtitles"] = ["I tuoi Interessi"];
$templateParams["side_content"] = [$dbh->getYourInterestProducts(10)];

// $templateParams['results'] = $dbh->getFavourites();
$templateParams["js"] = [JAVASCRIPT_DIR."favourite.js"];

checkLogin($dbh);

if(isset($_GET["cart"])) {
    $dbh->moveToCart($_GET["id"]);
}

if(isset($_GET["remove"])) {
    $dbh->removeFromFavourites($_GET["id"]);
}

require("../template/base.php")
?>