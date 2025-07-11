<?php
require_once("../database/init.php");

$result['logout'] = false;
if(isset($_POST["logout"]) && $_POST['logout'] === 'true') {
    $dbh->logout();
    $result['logout'] = true;
}

if(isset($_REQUEST["action"]) && isset($_REQUEST["id"])) {
    error_log($_REQUEST["action"]);
    error_log($_REQUEST["id"]);
    if($_REQUEST["action"] === "read") {
        $dbh->readNotification($_POST["id"]);
    } elseif($_REQUEST["action"] === "unread") {
        $dbh->unreadNotification($_REQUEST["id"]);
    } elseif($_REQUEST["action"] === "delete") {
        $dbh->deleteNotification($_REQUEST["id"]);
    }
}

$result["user"] = $dbh->getUser();
$result['user_type'] = $dbh->getUserType() === "client" ? 'Cliente' : 'Venditore';
$result["notifications"] = $dbh->getNotifications();

header('Content-Type: application/json');
echo json_encode($result);

?>