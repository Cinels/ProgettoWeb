<?php
require_once("../database/init.php");

if(isset($_POST["quantity"]) && isset($_POST['id'])) {
    $quantity = $dbh->getCartQuantity($_POST['id'])[0]['quantita'];
    if ($_POST['quantity'] > $quantity) {
        $dbh->addToCart($_POST['id'], $_POST['quantity'] - $quantity);
    } else {
        while($_POST['quantity'] < $quantity) {
            $dbh->removeOneFromCart($_POST['id']);
            $quantity = $dbh->getCartQuantity($_POST['id'])[0]['quantita'] ?? 0;
        }
    }
}

if(isset($_POST['action']) && isset($_POST['id'])) {
    if($_POST['action'] === 'remove') {
        $dbh->removeFromCart($_POST["id"], $dbh->getUser()['email']);
    } elseif($_POST['action'] === 'favourite') {
        $dbh->moveToFavourites($_POST["id"], $dbh->getUser()['email']);
    }
}

$cart = $dbh->getCart();
$totalPrice = 0.00;
foreach ($cart as $product) {
    $totalPrice += ($product['prezzoScontato']) * $product['quantita'];
}
$result = ['result' => $cart, 'total' => $totalPrice];

header('Content-Type: application/json');
echo json_encode($result);

?>