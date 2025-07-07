<?php
require_once("../database/init.php");
$templateParams["titolo"] = "Pagamento";
// $templateParams["main_content"] = ["user/payment.php"];
$templateParams['js'] = [JAVASCRIPT_DIR.'payment.js'];

require("../template/base.php")
?>