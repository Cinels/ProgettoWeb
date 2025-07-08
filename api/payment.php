<?php
require_once("../database/init.php");

$totalPrice = 0.00;
foreach ($dbh->getCart() as $product) {
        $totalPrice += ($product['prezzoScontato']) * $product['quantita'];
}

$result['total'] = $totalPrice;
$result['num_products'] = count($dbh->getCart());
$result['hasOrdered'] = false;

if(isset($_POST["card_number"]) && isset($_POST["expire_date"]) && isset($_POST["ccv"])){
    $result['hasOrdered'] = true;
    $dbh->createOrder("venditore@negozio.it");
    $idOrder=$dbh->createOrder("venditore@negozio.it");
    $soldout=$dbh->getSoldOutProductsNow($idOrder);
    if(count($soldout) > 0) {
        foreach($soldout as $exProd) {
            $dbh->notifySoldoutProduct($exProd, "venditore@negozio.it");
        }
    }
    $orderDetails=$dbh->getOrderDetails($idOrder);
    foreach($orderDetails['idProdotto'] as $product) {
        $dbh->manageLowQuantity($product, $dbh->getProduct($product)[0]['quantitaDisponibile']);
    }
    
}

header('Content-Type: application/json');
echo json_encode($result);
?>