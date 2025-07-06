<?php
require_once("../database/init.php");

$result['logout'] = false;
if(isset($_POST["logout"])) {
    $dbh->logout();
    $result['logout'] = true;
}

if(isset($_POST["notification"]) && isset($_POST["id"])) {
    if($_POST["notification"] === "read") {
        $dbh->readNotification($_POST["id"]);
    } elseif($_POST["notification"] === "unread") {
        $dbh->unreadNotification($_POST["id"]);
    } elseif($_POST["notification"] === "delete") {
        $dbh->deleteNotification($_POST["id"]);
    }
}

$result["user"] = $dbh->getUser();
$result['user_type'] = $dbh->getUserType() === "client" ? 'Cliente' : 'Venditore';
$result["notifications"] = $dbh->getNotifications();

header('Content-Type: application/json');
echo json_encode($result);

?>