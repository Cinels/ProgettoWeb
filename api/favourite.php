<?php
require_once("../database/init.php");

if(isset($_POST["action"])) {
    if($_POST["action"] === 'remove') {
        $dbh->removeFromFavourites($_POST["id"]);
    } elseif ($_POST['action'] === 'cart') {
        $dbh->moveToCart($_POST["id"]);
    }
}

$result = ['empty' => $dbh->getFavourites()[0]["idProdotto"] === null, 'result' => $dbh->getFavourites()];

header('Content-Type: application/json');
echo json_encode($result);

?>