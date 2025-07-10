<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Inserisci Prodotto";
$templateParams["h2"] = "Inserisci Prodotto";
$templateParams["main_content"] = ["user/manage_product.php"];
$templateParams["product"]["idPiattaforma"] = null;
$templateParams["product"]["tipo"] = null;

if (isset($_GET['id'])) {
    $templateParams["product"] = $dbh->getProductForUpdate($_GET['id'])[0];
    $templateParams["titolo"] = "Aggiorna Prodotto";
    $templateParams["h2"] = "Aggiorna prodotto";
    $templateParams["id"] = $_GET['id'];
    $templateParams["images"] = $dbh->getProductImages($_GET['id']);
}

// if(isset($_FILES["image"]) && $_FILES["image"]["name"] > 0) {
            //list($res, $img) = uploadImage(UPLOAD_DIR, $_FILES["image"]);

if (isset($_POST['nome'], $_POST['prezzo'], $_POST['quantitaDisponibile'], $_POST['descrizione'], $_POST['proprieta'],
    $_POST['offerta'], $_POST['piattaforma'], $_POST['tipo']))
    {
        var_dump("ehi");
        $res = 0;
        if(isset($_POST['update'])) {
            $id=$_POST['update'];
            $dbh->updateProduct($_POST['update'], $_POST['nome'], $_POST['prezzo'], $_POST['quantitaDisponibile'],
            $_POST['descrizione'], $_POST['proprieta'], $_POST['offerta'], $_POST['tipo'], $_POST['piattaforma']);
            if(isset($_FILES["image1"]) && $_FILES["image1"]["error"] == 0) {
                 list($res, $img)= uploadImage(getProductImagePath($_POST['tipo']), $_FILES["image1"]);
                 $dbh->updateImage($id, 1, ($res != 0 && isset($_FILES["image1"])) ? $img : null);
            }
            if(isset($_FILES["image2"]) && $_FILES["image2"]["error"] == 0) {
                 list($res, $img)= uploadImage(getProductImagePath($_POST['tipo']), $_FILES["image2"]);
                 $dbh->updateImage($id, 2, ($res != 0 && isset($_FILES["image2"])) ? $img : null);
            }
        } else if(isset($_FILES["image1"]) && $_FILES["image1"]["error"] == 0) {
            var_dump("wow");
            list($res1, $img1) = uploadImage(getProductImagePath($_POST['tipo']), $_FILES["image1"]);
            if(isset($_FILES["image2"]) && $_FILES["image2"]["error"] == 0) {
                list($res2, $img2) = uploadImage(getProductImagePath($_POST['tipo']), $_FILES["image2"]);
            }
            var_dump("res1: ".$res1);
            var_dump("img1: ".$img1);
            var_dump("res2: ".$res2);
            var_dump("img2: ".$img2);
            $id=$dbh->insertProduct($_POST['nome'], $_POST['prezzo'], $_POST['quantitaDisponibile'],
            $_POST['descrizione'], $_POST['proprieta'], $_POST['offerta'], $_POST['tipo'], $_POST['piattaforma'], ($res1 != 0 && isset($_FILES["image1"])) ? $img1 : null, ($res2 != 0 && isset($_FILES["image2"])) ? $img2 : null);
        }
    header("Location:".PAGES_DIR."product.php?search=".$id);
}

$templateParams['css'] = [CSS_DIR."base.css", CSS_DIR."style.css"];
require("../template/base.php")
?>