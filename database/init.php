<?php
session_start();
require("../utils/paths.php");
require("../utils/functions.php");
require_once("database.php");
$dbh = new DatabaseHelper("localhost", "root", "", "negozio_logico", 33061);
?>