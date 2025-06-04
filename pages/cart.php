<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Carrello";
$templateParams["main_content"] = ["user/cart.php"];
$templateParams["side_content"] = ["aside/your_interests.php"];

require("../template/base.php")
?>