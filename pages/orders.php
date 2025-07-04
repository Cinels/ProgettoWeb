<?php
require_once("../database/init.php");
$templateParams["titolo"] = "I tuoi Ordini";
// $templateParams["main_content"] = ["user/orders.php"];

$templateParams['js'] = [JAVASCRIPT_DIR."orders.js"];
// $templateParams['results'] = $dbh->getOrders();
$templateParams['order_state'] = ["Ordinato", "Spedito", "In consegna", "Consegnato"];

checkLogin($dbh);

require("../template/base.php")
?>