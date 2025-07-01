<?php
require_once("../database/init.php");

$results = ['empty' => $dbh->getOrders()[0]["idOrdine"] === null, 'result' => $dbh->getOrders()];
foreach($results["result"] as $res) {
    $details[$res["idOrdine"]] = $dbh->getOrderDetails($res["idOrdine"]);
}
$results['details'] = $details;

header('Content-Type: application/json');
echo json_encode($results);

?>