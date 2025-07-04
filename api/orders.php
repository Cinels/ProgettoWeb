<?php
require_once("../database/init.php");

$results['result'] = $dbh->getOrders();
$details = null;
foreach($results["result"] as $res) {
    $details[$res["idOrdine"]] = $dbh->getOrderDetails($res["idOrdine"]);
}
$results['details'] = $details;

header('Content-Type: application/json');
echo json_encode($results);

?>