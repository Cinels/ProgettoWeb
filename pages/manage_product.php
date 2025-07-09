<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Inserisci Prodotto";
$templateParams["h2"] = "Inserisci Prodotto";
$templateParams["main_content"] = ["user/manage_product.php"];
$templateParams["product"]["piattaforma"] = null;
$templateParams["product"]["tipo"] = null;

if (isset($_GET['product'])) {
    $templateParams["product"] = $dbh->getProductForUpdate($_GET['product'])[0];
    $templateParams["titolo"] = "Aggiorna Prodotto";
    $templateParams["h2"] = "Aggiorna prodotto";
    $templateParams["id"] = $_GET['product'];
}

// if(isset($_FILES["image"]) && $_FILES["image"]["name"] > 0) {
            //list($res, $img) = uploadImage(UPLOAD_DIR, $_FILES["image"]);

if (isset($_POST['nome'], $_POST['prezzo'], $_POST['quantitaDisponibile'], $_POST['descrizione'], $_POST['proprieta'],
    $_POST['offerta'], $_POST['piattaforma'], $_POST['tipo']))
    {
        var_dump("ehi");
        var_dump($_FILES["image"]);
        $res = 0;
        if(isset($_POST['update'])) {
            var_dump("noo");
            $id=$_POST['update'];
            $dbh->updateProduct($_POST['update'], $_POST['nome'], $_POST['prezzo'], $_POST['quantitaDisponibile'],
            $_POST['descrizione'], $_POST['proprieta'], $_POST['offerta'], $_POST['tipo'], $_POST['piattaforma']);
            if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
                 list($res, $img)= uploadImage(getProductImagePath($_POST['tipo']), $_FILES["image"]);
            }
        } else if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
            var_dump("wow");
            list($res, $img) = uploadImage(getProductImagePath($_POST['tipo']), $_FILES["image"]);
            $id=$dbh->insertProduct($_POST['nome'], $_POST['prezzo'], $_POST['quantitaDisponibile'],
            $_POST['descrizione'], $_POST['proprieta'], $_POST['offerta'], $_POST['tipo'], $_POST['piattaforma'], ($res != 0 && isset($_FILES["image"])) ? $img : null);
        }
    header("Location:".PAGES_DIR."product.php?search=".$id);
}

$templateParams['css'] = [CSS_DIR."base.css", CSS_DIR."style.css"];
require("../template/base.php")
?>