<?php
require_once("../database/init.php");

if(isset($_POST['state'], $_POST['id'])) {
    $dbh->updateOrderState($_POST['id'], $_POST['state']);
}

$results['result'] = $dbh->getOrders();
$results['type'] = ($dbh->getUserType() === "client" ? "Venditore" : "Cliente");
$details = null;
foreach($results["result"] as $res) {
    $details[$res["idOrdine"]] = $dbh->getOrderDetails($res["idOrdine"]);
}
$results['details'] = $details;
$results['order_state'] = ["Ordinato", "Spedito", "In consegna", "Consegnato"];

header('Content-Type: application/json');
echo json_encode($results);

?>