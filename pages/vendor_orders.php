<?php
require_once("../database/init.php");
$templateParams["titolo"] = "I tuoi Ordini";
$templateParams['results'] = $dbh->getOrders();
$templateParams['order_state'] = ["Ordinato", "Spedito", "In consegna", "Consegnato"];
$templateParams["main_content"] = ["user/vendor_orders.php"];

$templateParams['css'] = [CSS_DIR."style.css"];
checkLogin($dbh);
require("../template/base.php")
?>