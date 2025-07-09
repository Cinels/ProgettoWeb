<?php
require_once("../database/init.php");

$results['logged'] = null;

if(isset($_POST["cart"]) && checkClientLogin($dbh)) {
    $dbh->addToCart($_GET["search"], $_POST["cart"]);
}

if(isset($_POST["favourite"]) && checkClientLogin($dbh)) {
    if($_POST["favourite"] === "add" && !$dbh->isProductFavourite($_GET["search"])) {
        $dbh->addToFavourites($_GET["search"], $dbh->getUser()['email']);
    } elseif($_POST["favourite"] === "remove" && $dbh->isProductFavourite($_GET["search"])) {
        $dbh->removeFromFavourites($_GET["search"]);
    }
}

if(isset($_POST['vote']) && isset($_POST['review']) && isset($_POST['description']) && checkClientLogin($dbh)) {
    if($_POST['review'] === 'add') {
        $dbh->writeReview($_GET['search'], $_POST['vote'], $_POST['description']);
    } elseif ($_POST['review'] === 'edit') {
        $dbh->editReview($_GET['search'], $_POST['vote'], $_POST['description']);
    }
}

function checkClientLogin($dbh) {
    $results['logged'] = $dbh->isLogged() ? $dbh->getUserType() : null ;
    return $dbh->isLogged() && $dbh->getUserType() === "client";
}

$dbh->updateHistory($_GET["search"]);
$results['result'] = $dbh->getProduct($_GET["search"]);
$results['images'] = $dbh->getProductImages($_GET["search"]);
$results["reviews"] = $dbh->getReviews($_GET["search"]);
$results["hasBuyed"] = $dbh->hasBuyedIt($_GET["search"]);
$results["hasReviewed"] = $dbh->hasReviewedIt($_GET["search"]);
$results['isFavourite'] = $dbh->isProductFavourite($_GET['search']);
$results['userReview'] = $dbh->getUserReview($_GET['search']);

if(isset($_GET['more_rev']) && $_GET['more_rev'] === 'true') {
    $results["n_rev"] = count($results["reviews"]);
} else {
    $results["n_rev"] = min(4, count($results["reviews"])) - 0.1;
}

header('Content-Type: application/json');
echo json_encode($results);

?>