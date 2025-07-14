<?php
require_once("../database/init.php");

$result['result'] = null;
if (isset($_GET['suggestion'])) {
    if ($_GET['suggestion'] === 'sale') {
        $result['result'] = $dbh->getProductsOnSale(4);
    } elseif ($_GET['suggestion'] === 'trends') {
        $result['result'] = $dbh->getTrendProducts(4);
    } elseif ($_GET['suggestion'] === 'interests') {
        $result['result'] = $dbh->getYourInterestProducts(4);
    } elseif($_GET['suggestion'] === 'related' && isset($_GET['search'])) {
        $result['result'] = $dbh->getRelatedProducts($_GET['search'], 4);
    }
}

header('Content-Type: application/json');
echo json_encode($result);

?>