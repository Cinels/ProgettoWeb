<?php
require_once("../database/init.php");

if(isset($_POST["action"])) {
    if($_POST["action"] === 'remove') {
        $dbh->removeFromFavourites($_POST["id"]);
    } elseif ($_POST['action'] === 'cart') {
        $dbh->moveToCart($_POST["id"]);
    }
}

$favourites = $dbh->getFavourites();
$available = null;
$cartQuantity = null;
foreach ($favourites as $product) {
    $available[$product['idProdotto']] = $dbh->getAvailableProducts($product['idProdotto'])[0]['quantitaDisponibile'];
    $cartQuantity[$product['idProdotto']] = $dbh->getCartQuantity($product['idProdotto'])[0]['quantita'] ?? 0;
}
$result = ['result' => $favourites, 'available' => $available, 'cartQuantity' => $cartQuantity];


header('Content-Type: application/json');
echo json_encode($result);

?>