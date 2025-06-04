<?php
session_start();
require_once("database.php");
$dbh = new DatabaseHelper("localhost", "root", "", "progetto_web", 33061);
?>