<?php
require_once("../database/init.php");

$result = ['empty' => $dbh->getCart()[0]["idProdotto"] === null, 'result' => $dbh->getCart()];

header('Content-Type: application/json');
echo json_encode($result);

?>