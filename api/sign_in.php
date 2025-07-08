<?php
require_once("../database/init.php");

$result['edit'] = '';
$result['signin'] = '';

if(isset($_GET['action']) && $_GET['action'] === 'edit') {
    if(isset($_POST["old_password"]) && isset($_POST["name"]) && isset($_POST["surname"])) {
        if(isset($_FILES["image"]) && $_FILES["image"]["name"] > 0) {
            list($res, $img) = uploadImage(UPLOAD_DIR, $_FILES["image"]);
        } else {
            $res = 0;
        }
        if (!$dbh->checkLogin($dbh->getUser()['email'], $_POST['old_password'])) {
            $result["erroresignin"] = "Errore! La vecchia password è errata";
        } elseif (isset($_POST["password"]) && isset($_POST["check_password"]) && $_POST["password"] != $_POST["check_password"]) {
            $result["erroresignin"] = "Errore! Le nuove password non coincidono";
        } else {
            $edit = $dbh->editProfile($_POST['name'], $_POST['surname'], $_POST['old_password'], 
                ($_POST['password'] !== '') ? $_POST['password'] : null,
                ($res != 0 && isset($_FILES["image"])) ? $img : null);
            if ($edit) {
                $result['edit'] = 'success';
            } else {
                $result["erroresignin"] = "Errore! Modifica fallita";
            }
        }
    } else {
        $result["erroresignin"] = "Errore! Compilare tutti i campi";
    }
} else {
    if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["check_password"]) && isset($_POST["name"]) && isset($_POST["surname"])) {
        if(isset($_FILES["image"]) && $_FILES["image"]["name"] > 0) {
            list($res, $img) = uploadImage(UPLOAD_DIR, $_FILES["image"]);
        } else {
            $res = 0;
        }
        if($_POST["password"] != $_POST["check_password"]) {
            $result["erroresignin"] = "Errore! Le password non coincidono";
        } else {
            $signin = $dbh->signIn($_POST["name"], $_POST["surname"], $_POST["email"], $_POST["password"], ($res != 0 && isset($_FILES["image"])) ? $img : null);
            if($signin) {
                $result['signin'] = 'success';
            } else {
                $result["erroresignin"] = "Errore! Email non disponibile, ".$_POST['email'];
            }
        }
    } else {
        $result["erroresignin"] = "Errore! Compilare tutti i campi";
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'edit') {
    $result['user'] = $dbh->getUSer();
}

header('Content-Type: application/json');
echo json_encode($result);

?>