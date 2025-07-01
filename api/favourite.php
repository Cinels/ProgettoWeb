<?php
require_once("../database/init.php");

$result = ['empty' => $dbh->getFavourites()[0]["idProdotto"] === null, 'result' => $dbh->getFavourites()];

header('Content-Type: application/json');
echo json_encode($result);

?>