<?php
require_once("../database/init.php");

$result = $dbh->getCart();



if (count($result) > 0) {
    header('Content-Type: application/json');
    echo json_encode($result);
} else {
    echo "pippa";
}

?>