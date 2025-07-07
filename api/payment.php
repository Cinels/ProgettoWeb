<?php
require_once("../database/init.php");

$totalPrice = 0.00;
foreach ($dbh->getCart() as $product) {
    if ($product["offerta"] > 0) {
        $totalPrice += ($product["prezzo"] - $product["prezzo"]*($product["offerta"]/100)) * $product['quantita'];
    } else {
        $totalPrice += ($product['prezzo']) * $product['quantita'];
    }
}
$result['total'] = $totalPrice;
$result['num_products'] = count($dbh->getCart());
$result['hasOrdered'] = false;

if(isset($_POST["card_number"]) && isset($_POST["expire_date"]) && isset($_POST["ccv"])){
    $result['hasOrdered'] = true;
    $dbh->createOrder("venditore@negozio.it");
}

header('Content-Type: application/json');
echo json_encode($result);

?>