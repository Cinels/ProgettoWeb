<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Carrello";
$templateParams["main_content"] = ["user/cart.php"];
$templateParams["subtitles"] = ["I tuoi Interessi"];
$templateParams["side_content"] = [$dbh->getYourInterestProducts(10)];

if(!$dbh->isLogged()) {
    header("location: login.php");
}

require("../template/base.php")
?>