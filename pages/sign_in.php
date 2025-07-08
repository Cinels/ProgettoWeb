<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Registrati";
$templateParams['js'] = [JAVASCRIPT_DIR.'sign_in.js'];

require("../template/base.php")
?>