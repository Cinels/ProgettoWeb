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
        $dbh->removeFromCart($_POST["id"]);
    } elseif($_POST['action'] === 'favourite') {
        $dbh->moveToFavourites($_POST["id"]);
    }
}

$result = ['empty' => $dbh->getCart()[0]["idProdotto"] === null, 'result' => $dbh->getCart()];

header('Content-Type: application/json');
echo json_encode($result);

?>