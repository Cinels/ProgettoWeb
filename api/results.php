<?php 
require_once("../database/init.php");

if(isset($_POST["cart"]) && isset($_POST["id"])) {
    if($_POST["cart"] === "add") {
        $dbh->addToCart($_POST["id"], 1);
    }
}

if(isset($_POST["favourite"]) && isset($_POST["id"])) {
    if($_POST["favourite"] === "add") {
        $dbh->addToFavourites($_POST["id"]);
    } elseif($_POST["favourite"] === "remove") {
        $dbh->removeFromFavourites($_POST["id"]);
    }
}

$result["results"] = $dbh->getProductsFromResearch($_GET["search"]);
$result['user_type'] = $dbh->isLogged() ? $dbh->getUserType() : null;

$favourites = array();
foreach($dbh->getFavourites() as $product) {
    array_push($favourites, $product['idProdotto']);
}
$result['favourites'] = $favourites;

header('Content-Type: application/json');
echo json_encode($result);

?>