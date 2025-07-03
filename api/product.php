<?php
require_once("../database/init.php");

if(isset($_POST["cart"])) {
    checkClientLogin($dbh);
    $dbh->addToCart($_GET["search"], $_POST["cart"]);
    header("Location: ".PAGES_DIR."product.php?search=".$_GET["search"]);
}

if(isset($_POST["favourite"])) {
    checkClientLogin($dbh);
    if($_POST["favourite"] === "add" && !$dbh->isProductFavourite($_GET["search"])) {
        $dbh->addToFavourites($_GET["search"]);
    } elseif($_POST["favourite"] === "remove" && $dbh->isProductFavourite($_GET["search"])) {
        $dbh->removeFromFavourites($_GET["search"]);
    }
}

// if(isset($_GET['morerev'])) {
//     $results["n_rev"] = count($results["reviews"]);
// }

function checkClientLogin($dbh) {
    checkLogin($dbh);
    if($dbh->isLogged() && $dbh->getUserType() == "vendor") {
        header("location: profile.php");
        exit();
    }
}


$dbh->updateHistory($_GET["search"]);
$results['result'] = $dbh->getProduct($_GET["search"]);
$results['images'] = $dbh->getProductImages($_GET["search"]);
$results["reviews"] = $dbh->getReviews($_GET["search"]);
// $results["n_rev"] = min(4, count($results["reviews"]));
$results["hasBuyed"] = $dbh->hasBuyedIt($_GET["search"]);
$results["hasReviewed"] = $dbh->hasReviewedIt($_GET["search"]);
$results['isFavourite'] = $dbh->isProductFavourite($_GET['search']);


header('Content-Type: application/json');
echo json_encode($results);

?>