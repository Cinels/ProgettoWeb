<?php
require_once("../database/init.php");

$result['success'] = null;

if (isset($_POST['name'], $_POST['price'], $_POST['quantity'], $_POST['description'], $_POST['property'], $_POST['sale'], 
    $_POST['platform'], $_POST['type'])) {
    $res = 0;
    if(isset($_GET['id'])) {
        $dbh->updateProduct($_GET['id'], $_POST['name'], $_POST['price'], $_POST['quantity'],
        $_POST['description'], $_POST['property'], $_POST['sale'], $_POST['type'], $_POST['platform'][0]);
        if(isset($_FILES["image1"]) && $_FILES["image1"]["error"] == 0) {
            list($res, $img) = uploadImage(getProductImagePath($_POST['type']), $_FILES["image1"]);
            $dbh->updateImage($_GET['id'], 1, ($res != 0 && isset($_FILES["image1"])) ? $img : null);
        }
        if(isset($_FILES["image2"]) && $_FILES["image2"]["error"] == 0) {
            list($res, $img) = uploadImage(getProductImagePath($_POST['type']), $_FILES["image2"]);
            $dbh->updateImage($_GET['id'], 2, ($res != 0 && isset($_FILES["image2"])) ? $img : null);
        }
        $result['success'] = $_GET['id'];
    } else {
        $res1 = 0;
        $res2 = 0;
        if(isset($_FILES["image1"]) && $_FILES["image1"]["error"] == 0) {
            list($res1, $img1) = uploadImage(getProductImagePath($_POST['type']), $_FILES["image1"]);
        }
        if(isset($_FILES["image2"]) && $_FILES["image2"]["error"] == 0) {
            list($res2, $img2) = uploadImage(getProductImagePath($_POST['type']), $_FILES["image2"]);
        }
        $result['success'] = $dbh->insertProduct($_POST['name'], $_POST['price'], $_POST['quantity'],
            $_POST['description'], $_POST['property'], $_POST['sale'], $_POST['type'], $_POST['platform'][0], 
            ($res1 != 0 && isset($_FILES["image1"])) ? $img1 : null, ($res2 != 0 && isset($_FILES["image2"])) ? $img2 : null);
    }
}

if (isset($_GET['id'])) {
    $result["result"] = $dbh->getProductForUpdate($_GET['id'])[0];
    $result["images"] = $dbh->getProductImages($_GET['id']);
} else {
    $result['result'] = null;
    $result['images'] = null;
}

header('Content-Type: application/json');
echo json_encode($result);

?>