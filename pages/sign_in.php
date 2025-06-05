<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Registrati";
$templateParams["main_content"] = ["sign_in.php"];

if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["check_password"]) && isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["terms"])) {
    if($_POST["password"] != $_POST["check_password"]) {
        $templateParams["erroreSignin"] = "Errore! Le password non coincidono";
    } elseif (isset($_POST["image"])) {
        $signin = $dbh->signIn($_POST["name"], $_POST["surname"], $_POST["email"], $_POST["password"], $_POST["image"]);
    } else {
        $signin = $dbh->signIn($_POST["name"], $_POST["surname"], $_POST["email"], $_POST["password"], null);
    }
    if($signin) {
        header('Location:'.PAGES_DIR."index.php");
    } else {
        $templateParams["erroreSignin"] = "Errore! Email non disponibile";
    }
} else {
    $templateParams["erroreSignin"] = "Errore! Compilare tutti i campi";
}

require("../template/base.php")
?>