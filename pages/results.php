<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Risultati";
$templateParams["main_content"] = ["results.php"];
if(!($dbh->isLogged() && $dbh->getUserType() == "vendor")) {
    $templateParams["side_content"] = ["aside/on_sale.php", "aside/trends.php", "aside/your_interests.php"];
}

$templateParams["results"] = ["ciao", "come", "stai"];

require("../template/base.php")
?>