<?php
require_once("../database/init.php");

if(isset($_POST['id'], $_POST['remove'])) {
    $dbh->removeProduct($_POST['id']);
}

$result["results"] = $dbh->getVendorProducts();

header('Content-Type: application/json');
echo json_encode($result);

?>