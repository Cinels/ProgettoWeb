<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Prodotto";
$templateParams["main_content"] = ["product.php"];
$templateParams["side_content"] = ["aside/related.php"];

require("../template/base.php")
?>