<?php
require_once("../database/init.php");

$result = $dbh->getFavourites();



if (count($result) > 0) {
    header('Content-Type: application/json');
    echo json_encode($result);
}

?>