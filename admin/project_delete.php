<?php
require_once "auth.php";
require_once "../config/db.php";
/*--Check project ID--*/

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: projects.php");
    exit();
}

$project_id = (int) $_GET["id"];

/*--Get image path before deleting--*/
$stmt = $conn->prepare("
    SELECT image
    FROM projects
    WHERE project_id = ?
    LIMIT 1
");

$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();
$image = "";

if ($result->num_rows === 1) {

    $project = $result->fetch_assoc();
    $image = $project["image"];

}

$stmt->close();

/*--Delete project--*/
$stmt = $conn->prepare("
    DELETE FROM projects
    WHERE project_id = ?
");

$stmt->bind_param("i", $project_id);
$stmt->execute();
$stmt->close();


/*--Delete uploaded image if it exists--*/
if (!empty($image)) {

    $image_path = "../" . $image;

    if (file_exists($image_path)) {
        unlink($image_path);
    }

}

/*--Return to projects--*/
header("Location: projects.php");
exit();
?>