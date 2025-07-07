<?php
require_once("../database/init.php");

if(isset($_POST["email"]) && isset($_POST["password"])) {
    $result = ['success' => false, 'message' => 'Si è verificato un errore sconosciuto.'];
    if ($dbh->checkLogin($_POST["email"], $_POST["password"])) {
        $result = ['success' => true, 'message' => 'Login avvenuto con successo!'];
    } else {
        $result = ['success' => false, 'message' => 'Email o password non validi.'];
    }
    header('Content-Type: application/json');
    echo json_encode($result);
}
?>