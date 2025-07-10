<?php
require_once("../database/init.php");
$templateParams["titolo"] = "I tuoi prodotti";
$templateParams["main_content"] = ["user/vendor_products.php"];
$templateParams["products"] = $dbh->getVendorProducts();

if(isset($_POST['id'], $_POST['remove'])) {
    $dbh->removeProduct($_POST['id']);
}


$templateParams['css'] = [CSS_DIR."style.css"];
require("../template/base.php")
?>