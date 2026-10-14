<?php
require_once "auth.php";
require_once "../config/db.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: services.php");
    exit();
}

$service_id = (int) $_GET["id"];

$stmt = $conn->prepare(
    "DELETE FROM services WHERE service_id = ?"
);

$stmt->bind_param("i", $service_id);
$stmt->execute();
$stmt->close();

header("Location: services.php");
exit();
?>