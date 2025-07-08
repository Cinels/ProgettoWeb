<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Il Puzzo";
$templateParams["js"] = [JAVASCRIPT_DIR."home.js"];
if(!($dbh->isLogged() && $dbh->getUserType() == "vendor")) {
    $templateParams['js'][] = JAVASCRIPT_DIR."suggestions.js";
}

require("../template/base.php");
?>