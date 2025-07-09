<?php
function checkLogin($dbh) {
    if(!$dbh->isLogged()) {
        header("location: login.php");
        exit();
    }
}

function uploadImage($path, $image){
    $imageName = basename($image["name"]);
    $fullPath = DB_RESOURCES_DIR.$path.$imageName;
    $maxKB = 5000;
    $acceptedExtensions = array("jpg", "jpeg", "png", "gif");
    $result = 0;
    $msg = "";
    //Controllo se immagine è veramente un'immagine
    $imageSize = getimagesize($image["tmp_name"]);
    if($imageSize === false) {
        $msg .= "File caricato non è un'immagine! ";
    }
    //Controllo dimensione dell'immagine < 5000KB
    if ($image["size"] > $maxKB * 1024) {
        $msg .= "File caricato pesa troppo! Dimensione massima è $maxKB KB. ";
    }

    //Controllo estensione del file
    $imageFileType = strtolower(pathinfo($fullPath,PATHINFO_EXTENSION));
    if(!in_array($imageFileType, $acceptedExtensions)){
        $msg .= "Accettate solo le seguenti estensioni: ".implode(",", $acceptedExtensions);
    }

    //Se non ci sono errori, sposto il file dalla posizione temporanea alla cartella di destinazione
    if(strlen($msg)==0){
        if(!move_uploaded_file($image["tmp_name"], $fullPath)){
            $msg.= "Errore nel caricamento dell'immagine.";
        }
        else{
            $result = 1;
            $msg = $path.$imageName;
        }
    }
    return array($result, $msg);
}

function getProductImagePath($type) {
    switch ($type) {
        case 1:
            return 'Console/';
            break;
        case 2:
            return 'Controller/';
            break;
        case 3:
            return 'Videogiochi/';
            break;
        
        default:
            return '/';
            break;
    }
}
?>