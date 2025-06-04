<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Aggiungi Prodotto";
$templateParams["main_content"] = ["user/add_product.php"];

require("../template/base.php")
?>