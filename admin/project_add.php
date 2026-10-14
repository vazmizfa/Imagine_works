<?php
require_once "auth.php";
require_once "../config/db.php";
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $project_name = trim($_POST["project_name"]);
    $short_description = trim($_POST["short_description"]);
    $full_description = trim($_POST["full_description"]);
    $project_url = trim($_POST["project_url"]);
    $category = trim($_POST["category"]);
    $featured = isset($_POST["featured"]) ? 1 : 0;
    $display_order = (int) $_POST["display_order"];
    $status = isset($_POST["status"]) ? 1 : 0;

    $image = "";

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

        /*--INSERT PROJECT--*/
        if ($error === "") {

            $stmt = $conn->prepare("
                INSERT INTO projects
                (
                    project_name,
                    short_description,
                    full_description,
                    image,
                    project_url,
                    category,
                    featured,
                    display_order,
                    status
                )
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->bind_param(
                "ssssssiii",
                $project_name,
                $short_description,
                $full_description,
                $image,
                $project_url,
                $category,
                $featured,
                $display_order,
                $status
            );

            if ($stmt->execute()) {

                $stmt->close();

                header("Location: projects.php");
                exit();

            } else {

                $error = "Failed to add project.";

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

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Project | Imagine Works</title>

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
        <h1>Add New Project</h1>
        <p class="subtitle">
            Add a new project to the Imagine Works portfolio.
        </p>

        <?php if ($error !== ""): ?>

            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>


        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="project_name">
                    Project Name *
                </label>

                <input
                    type="text"
                    name="project_name"
                    id="project_name"
                    required
                >
            </div>


            <div class="form-group">
                <label for="category">
                    Category
                </label>

                <input
                    type="text"
                    name="category"
                    id="category"
                    placeholder="Example: Web Development"
                >
            </div>


            <div class="form-group">
                <label for="short_description">
                    Short Description
                </label>

                <textarea
                    name="short_description"
                    id="short_description"
                    placeholder="Short description of the project"
                ></textarea>
            </div>


            <div class="form-group">
                <label for="full_description">
                    Full Description
                </label>

                <textarea
                    name="full_description"
                    id="full_description"
                    placeholder="Complete description of the project"
                ></textarea>
            </div>


            <div class="form-group">
                <label for="image">
                    Project Image
                </label>

                <input
                    type="file"
                    name="image"
                    id="image"
                    accept="image/jpeg,image/png,image/webp,image/gif"
                >

                <p class="hint">
                    Optional. JPG, PNG, WEBP or GIF. Maximum 5 MB.
                </p>
            </div>


            <div class="form-group">
                <label for="project_url">
                    Project URL
                </label>

                <input
                    type="url"
                    name="project_url"
                    id="project_url"
                    placeholder="https://example.com"
                >

            </div>


            <div class="form-group">
                <label for="display_order">
                    Display Order
                </label>

                <input
                    type="number"
                    name="display_order"
                    id="display_order"
                    value="1"
                    min="1"
                    required
                >

                <p class="hint">
                    Smaller numbers appear first.
                </p>
            </div>


            <div class="checkbox-group">
                <input
                    type="checkbox"
                    name="featured"
                    id="featured"
                >

                <label for="featured">
                    Featured Project
                </label>
            </div>


            <div class="checkbox-group">
                <input
                    type="checkbox"
                    name="status"
                    id="status"
                    checked
                >

                <label for="status">
                    Active
                </label>
            </div>


            <button type="submit">
                Save Project
            </button>
        </form>


        <a href="projects.php" class="back">
            ← Back to Projects
        </a>
    </div>
</div>
</body>
</html>