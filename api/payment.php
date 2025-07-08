<?php
require_once("../database/init.php");

$totalPrice = 0.00;
$numberProducts = 0;
foreach ($dbh->getCart() as $product) {
    $totalPrice += ($product['prezzoScontato']) * $product['quantita'];
    $numberProducts += $product['quantita'];
}
$result['total'] = $totalPrice;
$result['num_products'] = $numberProducts;
$result['hasOrdered'] = false;

if(isset($_POST["card_number"]) && isset($_POST["expire_date"]) && isset($_POST["ccv"])){
    $result['hasOrdered'] = true;
    $dbh->createOrder("venditore@negozio.it");
}

header('Content-Type: application/json');
echo json_encode($result);

?>