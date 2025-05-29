<?php
$templateParams["titolo"] = "Il Puzzo";
$templateParams["main_content"] = ["home.php"];
if(true/* not login venditore */) {
    $templateParams["side_content"] = ["aside/on_sale.php", "aside/trends.php", "aside/your_interests.php"];
}

require("../template/base.php");
?>