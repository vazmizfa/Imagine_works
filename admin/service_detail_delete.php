<?php
require_once "auth.php";
require_once "../config/db.php";

/*--Check ID--*/

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: service_details.php");
    exit();
}

$detail_id = (int) $_GET["id"];


/*--Delete service detail--*/

$stmt = $conn->prepare("
    DELETE FROM service_details
    WHERE detail_id = ?
");

$stmt->bind_param("i", $detail_id);
$stmt->execute();
$stmt->close();


/*--Go back to service details--*/
header("Location: service_details.php");
exit();
?>