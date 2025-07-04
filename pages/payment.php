<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Errore";
$templateParams["main_content"] = ["user/payment.php"];

if(isset($_POST['tot'])) {
    $templateParams["titolo"] = "Pagamento";
    $templateParams["tot"] = $_POST['tot'];
} elseif(isset($_POST["card_number"]) && isset($_POST["expire_date"]) && isset($_POST["ccv"])){
    $dbh->createOrder("venditore@negozio.it");
    //Alert ordine effettuato con successo
    header("Location: orders.php");
}


require("../template/base.php")
?>