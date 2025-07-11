<?php
require_once("../database/init.php");

$results['logged'] = checkClientLogin($dbh);

if(isset($_POST["cart"]) && checkClientLogin($dbh) === 'client') {
    $dbh->addToCart($_GET["search"], $_POST["cart"]);
}

if(isset($_POST["favourite"]) && checkClientLogin($dbh) === 'client') {
    if($_POST["favourite"] === "add" && !$dbh->isProductFavourite($_GET["search"])) {
        $dbh->addToFavourites($_GET["search"], $dbh->getUser()['email']);
    } elseif($_POST["favourite"] === "remove" && $dbh->isProductFavourite($_GET["search"])) {
        $dbh->removeFromFavourites($_GET["search"]);
    }
}

if(isset($_POST['vote']) && isset($_POST['review']) && isset($_POST['description']) && checkClientLogin($dbh) === 'client') {
    if($_POST['review'] === 'add') {
        $dbh->writeReview($_GET['search'], $_POST['vote'], $_POST['description']);
    } elseif ($_POST['review'] === 'edit') {
        $dbh->editReview($_GET['search'], $_POST['vote'], $_POST['description']);
    }
}

function checkClientLogin($dbh) {
    return $dbh->isLogged() ? $dbh->getUserType() : null ;
}

$dbh->updateHistory($_GET["search"]);
$results['result'] = $dbh->getProduct($_GET["search"]);
$results['images'] = $dbh->getProductImages($_GET["search"]);
$results["reviews"] = $dbh->getReviews($_GET["search"]);
$results["hasBuyed"] = $dbh->hasBuyedIt($_GET["search"]);
$results["hasReviewed"] = $dbh->hasReviewedIt($_GET["search"]);
$results['isFavourite'] = $dbh->isProductFavourite($_GET['search']);
$results['userReview'] = $dbh->getUserReview($_GET['search'])[0] ?? null;
$results['cartQuantity'] = $dbh->getCartQuantity($_GET['search'])[0]['quantita'] ?? 0;

if(isset($_GET['more_rev']) && $_GET['more_rev'] === 'true') {
    $results["n_rev"] = count($results["reviews"]);
} else {
    $results["n_rev"] = min(4, count($results["reviews"])) - 0.1;
}

header('Content-Type: application/json');
echo json_encode($results);

?>