<?php
require_once "auth.php";
require_once "../config/db.php";
$error = "";


/*--Check project ID--*/
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: projects.php");
    exit();
}

$project_id = (int) $_GET["id"];


/*--Get existing project--*/
$stmt = $conn->prepare("
    SELECT *
    FROM projects
    WHERE project_id = ?
    LIMIT 1
");

$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {

    $stmt->close();

    header("Location: projects.php");
    exit();
}

$project = $result->fetch_assoc();
$stmt->close();


/*--Update project--*/
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $project_name = trim($_POST["project_name"]);
    $short_description = trim($_POST["short_description"]);
    $full_description = trim($_POST["full_description"]);
    $project_url = trim($_POST["project_url"]);
    $category = trim($_POST["category"]);
    $featured = isset($_POST["featured"]) ? 1 : 0;
    $display_order = (int) $_POST["display_order"];
    $status = isset($_POST["status"]) ? 1 : 0;

    $image = $project["image"];


    /*--Check project name--*/
    if ($project_name === "") {

        $error = "Please enter the project name.";

    } else {


        /*--IMAGE UPLOAD--*/
        if (
            isset($_FILES["image"]) &&
            $_FILES["image"]["error"] !== UPLOAD_ERR_NO_FILE
        ) {

            if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {

                $error = "There was a problem uploading the image.";

            } elseif ($_FILES["image"]["size"] > 5 * 1024 * 1024) {

                $error = "Image must be less than 5 MB.";

            } else {

                $allowed_types = [
                    "image/jpeg" => "jpg",
                    "image/png" => "png",
                    "image/webp" => "webp",
                    "image/gif" => "gif"
                ];

                $file_tmp = $_FILES["image"]["tmp_name"];
                $file_type = mime_content_type($file_tmp);

                if (!isset($allowed_types[$file_type])) {

                    $error = "Only JPG, PNG, WEBP and GIF images are allowed.";

                } else {

                    $upload_directory = "../img/projects/";

                    if (!is_dir($upload_directory)) {
                        mkdir($upload_directory, 0755, true);
                    }

                    $extension = $allowed_types[$file_type];

                    $filename =
                        "project_" .
                        bin2hex(random_bytes(8)) .
                        "." .
                        $extension;

                    $destination = $upload_directory . $filename;

                    if (move_uploaded_file($file_tmp, $destination)) {

                        $image = "img/projects/" . $filename;

                    } else {

                        $error = "Could not save the uploaded image.";

                    }
                }
            }
        }

        /*--UPDATE DATABASE--*/
        if ($error === "") {

            $stmt = $conn->prepare("
                UPDATE projects
                SET
                    project_name = ?,
                    short_description = ?,
                    full_description = ?,
                    image = ?,
                    project_url = ?,
                    category = ?,
                    featured = ?,
                    display_order = ?,
                    status = ?
                WHERE project_id = ?
            ");

            $stmt->bind_param(
                "ssssssiiii",
                $project_name,
                $short_description,
                $full_description,
                $image,
                $project_url,
                $category,
                $featured,
                $display_order,
                $status,
                $project_id
            );

            if ($stmt->execute()) {

                $stmt->close();

                header("Location: projects.php");
                exit();

            } else {

                $error = "Failed to update project.";

            }

            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Edit Project | Imagine Works</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body 
        {
            background: #0e0e0e;
            color: white;
            font-family: Arial, sans-serif;
        }

        .container 
        {
            width: 90%;
            max-width: 750px;
            margin: 45px auto;
        }

        .form-box 
        {
            background: #181818;
            border: 1px solid #2b2b2b;
            border-radius: 15px;
            padding: 35px;
        }

        h1 
        {
            margin-bottom: 10px;
        }

        .subtitle 
        {
            color: #999;
            margin-bottom: 30px;
        }

        .form-group 
        {
            margin-bottom: 22px;
        }

        label 
        {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input,
        textarea 
        {
            width: 100%;
            padding: 13px;
            border: 1px solid #333;
            border-radius: 8px;
            background: #0e0e0e;
            color: white;
            font-family: Arial, sans-serif;
            outline: none;
        }

        input:focus,
        textarea:focus 
        {
            border-color: #A855F7;
        }

        textarea 
        {
            min-height: 110px;
            resize: vertical;
        }

        input[type="file"] 
        {
            padding: 10px;
        }

        .hint 
        {
            color: #888;
            font-size: 12px;
            margin-top: 7px;
        }

        .current-image 
        {
            margin-top: 12px;
        }

        .current-image img 
        {
            width: 180px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #333;
        }

        .no-image 
        {
            color: #777;
            font-size: 13px;
        }

        .checkbox-group 
        {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
        }

        .checkbox-group input 
        {
            width: auto;
        }

        .checkbox-group label 
        {
            margin: 0;
        }

        .error 
        {
            background: #351515;
            color: #ff8c8c;
            padding: 13px;
            border-radius: 8px;
            margin-bottom: 22px;
        }

        button 
        {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: #A855F7;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover 
        {
            opacity: 0.9;
        }

        .back 
        {
            display: inline-block;
            margin-top: 22px;
            color: #aaa;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-box">
        <h1>Edit Project</h1>
        <p class="subtitle">
            Update the project information.
        </p>


        <?php if ($error !== ""): ?>
            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>


        <form method="POST" enctype="multipart/form-data">

            <!--PROJECT NAME-->
            <div class="form-group">
                <label for="project_name">
                    Project Name *
                </label>

                <input
                    type="text"
                    name="project_name"
                    id="project_name"
                    value="<?php echo htmlspecialchars($project["project_name"]); ?>"
                    required
                >

            </div>

            <!--CATEGORY-->
            <div class="form-group">
                <label for="category">
                    Category
                </label>

                <input
                    type="text"
                    name="category"
                    id="category"
                    value="<?php echo htmlspecialchars($project["category"]); ?>"
                    placeholder="Example: Web Development"
                >
            </div>


            <!--SHORT DESCRIPTION-->
            <div class="form-group">
                <label for="short_description">
                    Short Description
                </label>

                <textarea
                    name="short_description"
                    id="short_description"
                ><?php echo htmlspecialchars($project["short_description"]); ?></textarea>
            </div>


            <!--FULL DESCRIPTION-->
            <div class="form-group">
                <label for="full_description">
                    Full Description
                </label>

                <textarea
                    name="full_description"
                    id="full_description"
                ><?php echo htmlspecialchars($project["full_description"]); ?></textarea>
            </div>


            <!--IMAGE-->
            <div class="form-group">
                <label for="image">
                    Change Project Image
                </label>

                <input
                    type="file"
                    name="image"
                    id="image"
                    accept="image/jpeg,image/png,image/webp,image/gif"
                >

                <p class="hint">
                    Leave empty to keep the current image.
                </p>


                <div class="current-image">
                    <?php if (!empty($project["image"])): ?>

                        <img
                            src="../<?php echo htmlspecialchars($project["image"]); ?>"
                            alt="Current project image"
                        >
                    <?php else: ?>

                        <p class="no-image">
                            No project image uploaded.
                        </p>

                    <?php endif; ?>

                </div>
            </div>


            <!--PROJECT URL-->
            <div class="form-group">
                <label for="project_url">
                    Project URL
                </label>

                <input
                    type="url"
                    name="project_url"
                    id="project_url"
                    value="<?php echo htmlspecialchars($project["project_url"]); ?>"
                    placeholder="https://example.com"
                >
            </div>


            <!--DISPLAY ORDER-->
            <div class="form-group">
                <label for="display_order">
                    Display Order
                </label>

                <input
                    type="number"
                    name="display_order"
                    id="display_order"
                    value="<?php echo $project["display_order"]; ?>"
                    min="1"
                    required
                >

                <p class="hint">
                    Smaller numbers appear first.
                </p>
            </div>


            <!--FEATURED-->
            <div class="checkbox-group">
                <input
                    type="checkbox"
                    name="featured"
                    id="featured"
                    <?php
                    if ($project["featured"] == 1) {
                        echo "checked";
                    }
                    ?>
                >

                <label for="featured">
                    Featured Project
                </label>

            </div>


            <!--STATUS-->
            <div class="checkbox-group">
                <input
                    type="checkbox"
                    name="status"
                    id="status"
                    <?php
                    if ($project["status"] == 1) {
                        echo "checked";
                    }
                    ?>
                >

                <label for="status">
                    Active
                </label>
            </div>


            <button type="submit">
                Update Project
            </button>
        </form>
        <a href="projects.php" class="back">
            ← Back to Projects
        </a>
    </div>
</div>
</body>
</html>