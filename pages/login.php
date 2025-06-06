<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Accedi";
$templateParams["main_content"] = ["login.php"];

if(isset($_POST["email"]) && isset($_POST["password"])) {
    if($dbh->checkLogin($_POST["email"], $_POST["password"])) {
        header('Location:'.PAGES_DIR."index.php");
    } else {
        $templateParams["errorelogin"] = "Errore! Controllare username e password";
    }
}

require("../template/base.php")
?>