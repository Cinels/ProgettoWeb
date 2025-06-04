<?php
require_once("../database/init.php");
$templateParams["titolo"] = "I tuoi Ordini";
$templateParams["main_content"] = ["user/orders.php"];

require("../template/base.php")
?>