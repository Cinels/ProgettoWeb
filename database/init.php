<?php
session_start();
require("../utils/paths.php");
require("../utils/functions.php");
require_once("database.php");
setlocale(LC_TIME, 'it_IT.utf8', 'ita', 'it_IT', 'italian');
$dbh = new DatabaseHelper("localhost", "root", "", "negozio_logico", 33061);
?>