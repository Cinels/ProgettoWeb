<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Gestisci Prodotto";
$templateParams["main_content"] = ["user/manage_product.php"];

require("../template/base.php")
?>