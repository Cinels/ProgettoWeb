<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Errore";
$templateParams["main_content"] = ["write_review.php"];

if(isset($_GET['id'])) {
    $templateParams['product'] = $dbh->getProduct($_GET['id']);
    $templateParams["titolo"] = "Recensione - ".$templateParams['product'][0]['nome'];
    $templateParams['img'] = $dbh->getProductImages($_GET['id'])[0];
}

if(isset($_POST['id']) && isset($_POST['vote'])) {
    $dbh->writeReview($_POST['id'], $_POST['vote'], $_POST['desc'] ?? NULL);
    header("Location: ".PAGES_DIR."product.php?search=".$_REQUEST["id"]);
}

require("../template/base.php")
?>