<?php
require_once "auth.php";
require_once "../config/db.php";
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: messages.php");
    exit();
}

$message_id = (int) $_GET["id"];
$stmt = $conn->prepare("
    DELETE FROM messages
    WHERE message_id = ?
");

$stmt->bind_param("i", $message_id);
$stmt->execute();
$stmt->close();
header("Location: messages.php");
exit();
?>