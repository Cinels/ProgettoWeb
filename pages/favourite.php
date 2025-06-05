<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Lista Preferiti";
$templateParams["main_content"] = ["user/favourites.php"];
$templateParams["side_content"] = [$dbh->getYourInterestProducts(10)];


require("../template/base.php")
?>