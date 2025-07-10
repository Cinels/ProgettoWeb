<?php
require_once("../database/init.php");

$results['result'] = $dbh->getOrders();
$results['type'] = ($dbh->getUserType() == "client" ? "Venditore" : "Cliente");
//var_dump($results['result']);
$details = null;
foreach($results["result"] as $res) {
    $details[$res["idOrdine"]] = $dbh->getOrderDetails($res["idOrdine"]);
}
$results['details'] = $details;
$results['order_state'] = ["Ordinato", "Spedito", "In consegna", "Consegnato"];

if(isset($_POST['stato'], $_POST['id'])) {
    $dbh->updateOrderState($_POST['id'], $_POST['stato']);
}

header('Content-Type: application/json');
echo json_encode($results);

?>