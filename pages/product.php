<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Prodotto";
$templateParams["main_content"] = ["product.php"];
$templateParams["side_content"] = [$dbh->getRelatedProducts(10)];

require("../template/base.php")
?>