<?php 
require_once("../database/init.php");

if(isset($_POST["cart"]) && isset($_POST["id"])) {
    if($_POST["cart"] === "add") {
        $dbh->addToCart($_POST["id"], 1);
    }
}

if(isset($_POST["favourite"]) && isset($_POST["id"])) {
    if($_POST["favourite"] === "add") {
        $dbh->addToFavourites($_POST["id"], $dbh->getUser()['email']);
    } elseif($_POST["favourite"] === "remove") {
        $dbh->removeFromFavourites($_POST["id"]);
    }
}

$search_results = $dbh->getProductsFromResearch($_GET["search"]);
$available = null;
$cartQuantity = null;
foreach ($search_results as $product) {
    $available[$product['idProdotto']] = $dbh->getAvailableProducts($product['idProdotto'])[0]['quantitaDisponibile'];
    $cartQuantity[$product['idProdotto']] = $dbh->getCartQuantity($product['idProdotto'])[0]['quantita'] ?? 0;
}
$result["results"] = $search_results;
$result['user_type'] = $dbh->isLogged() ? $dbh->getUserType() : null;
$result['available'] = $available;
$result['cartQuantity'] = $cartQuantity;

$favourites = array();
$dbfav = $dbh->getFavourites();
if($dbfav != NULL) {
    foreach($dbfav as $product) {
        array_push($favourites, $product['idProdotto']);
    }
}
$result['favourites'] = $favourites;

header('Content-Type: application/json');
echo json_encode($result);

?>