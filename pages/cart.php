<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Carrello";

// $templateParams["main_content"] = ["user/cart.php"];
$templateParams["subtitles"] = ["I tuoi Interessi"];
$templateParams["side_content"] = [$dbh->getYourInterestProducts(10)];

// $templateParams["results"] = $dbh->getCart();
$templateParams["js"] = [JAVASCRIPT_DIR."cart.js"];

checkLogin($dbh);

require("../template/base.php")
?>