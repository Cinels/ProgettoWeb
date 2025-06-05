<?php
session_start();
require("../utils/paths.php");
require_once("database.php");
$dbh = new DatabaseHelper("localhost", "root", "", "negozio_logico", 33061);
if(!isset($_SESSION["is_logged"])) {
    $_SESSION["is_logged"] = false;
    $_SESSION["user_type"] = null;
    $_SESSION["user"] = null;
}
?>