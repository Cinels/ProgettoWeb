<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../database/init.php");

$totalPrice = 0.00;
$numberProducts = 0;
foreach ($dbh->getCart() as $product) {
    $totalPrice += ($product['prezzoScontato']) * $product['quantita'];
    $numberProducts += $product['quantita'];
}
$result['total'] = round($totalPrice,2);
$result['num_products'] = $numberProducts;
$result['hasOrdered'] = false;

if(isset($_POST["card_number"]) && isset($_POST["expire_date"]) && isset($_POST["ccv"])){
    $result['hasOrdered'] = true;
    $idOrder=$dbh->createOrder("venditore@negozio.it");
    $soldout=$dbh->getSoldOutProductsNow($idOrder);
    if(count($soldout) > 0) {
        foreach($soldout as $exProd) {
            $dbh->notifySoldoutProduct($exProd, "venditore@negozio.it");
        }
    }
    $orderDetails=$dbh->getOrderDetails($idOrder);
    foreach($orderDetails as $product) {
        $dbh->manageLowQuantity($product['idProdotto'], $dbh->getProduct($product)[0]['quantitaDisponibile']);
    }
    
}

header('Content-Type: application/json');
echo json_encode($result);
?>