<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Lista Preferiti";
$templateParams["main_content"] = ["user/favourites.php"];
$templateParams["subtitles"] = ["I tuoi Interessi"];
$templateParams["side_content"] = [$dbh->getYourInterestProducts(10)];

$templateParams['results'] = $dbh->getFavourites();

if(!$dbh->isLogged()) {
    header("location: login.php");
}

require("../template/base.php")
?>