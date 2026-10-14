<?php
require_once "auth.php";
require_once "../config/db.php";
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $service_name = trim($_POST["service_name"]);
    $short_description = trim($_POST["short_description"]);
    $icon = trim($_POST["icon"]);
    $image = trim($_POST["image"]);
    $display_order = (int) $_POST["display_order"];
    $status = isset($_POST["status"]) ? 1 : 0;

    if ($service_name === "") {

        $error = "Service name is required.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO services 
            (service_name, short_description, icon, image, display_order, status)
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssssii",
            $service_name,
            $short_description,
            $icon,
            $image,
            $display_order,
            $status
        );

        if ($stmt->execute()) {

            header("Location: services.php");
            exit();

        } else {

            $error = "Error adding service: " . $stmt->error;

        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Service | Imagine Works</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body 
        {
            font-family: Arial, sans-serif;
            background: #0e0e0e;
            color: #ffffff;
        }

        .sidebar 
        {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: #151515;
            border-right: 1px solid #292929;
            padding: 25px 15px;
        }

        .logo 
        {
            font-size: 23px;
            font-weight: bold;
            color: #A855F7;
            padding: 0 15px;
            margin-bottom: 40px;
        }

        .menu-title 
        {
            color: #777;
            font-size: 12px;
            text-transform: uppercase;
            padding: 0 15px;
            margin-bottom: 10px;
        }

        .menu a 
        {
            display: block;
            text-decoration: none;
            color: #cccccc;
            padding: 13px 15px;
            border-radius: 8px;
            margin-bottom: 5px;
        }

        .menu a:hover,
        .menu a.active 
        {
            background: #A855F7;
            color: #ffffff;
        }

        .logout 
        {
            position: absolute;
            bottom: 25px;
            left: 15px;
            right: 15px;
        }

        .logout a 
        {
            display: block;
            text-align: center;
            padding: 12px;
            background: #242424;
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
        }

        .main 
        {
            margin-left: 250px;
            padding: 35px;
            max-width: 1000px;
        }

        .page-header 
        {
            margin-bottom: 30px;
        }

        .page-header h1 
        {
            font-size: 30px;
            margin-bottom: 8px;
        }

        .page-header p 
        {
            color: #888;
        }

        .form-box 
        {
            background: #181818;
            border: 1px solid #292929;
            border-radius: 12px;
            padding: 30px;
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
            font-weight: bold;
        }

        input,
        textarea 
        {
            width: 100%;
            padding: 13px;
            background: #0e0e0e;
            border: 1px solid #333;
            border-radius: 7px;
            color: #ffffff;
            outline: none;
            font-family: Arial, sans-serif;
        }

        input:focus,
        textarea:focus 
        {
            border-color: #A855F7;
        }

        textarea 
        {
            min-height: 130px;
            resize: vertical;
        }

        .hint 
        {
            display: block;
            margin-top: 6px;
            color: #777;
            font-size: 12px;
        }

        .checkbox-group 
        {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkbox-group input 
        {
            width: auto;
        }

        .buttons 
        {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }

        .btn 
        {
            padding: 12px 20px;
            border-radius: 7px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .save-btn 
        {
            background: #A855F7;
            color: #ffffff;
        }

        .cancel-btn 
        {
            background: #333333;
            color: #ffffff;
        }

        .error 
        {
            background: #351515;
            color: #ff9999;
            padding: 12px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        @media (max-width: 700px) 
        {

            .sidebar 
            {
                position: relative;
                width: 100%;
                height: auto;
            }

            .logout 
            {
                position: relative;
                left: auto;
                right: auto;
                bottom: auto;
                margin-top: 20px;
            }

            .main 
            {
                margin-left: 0;
                padding: 20px;
            }

        }

    </style>
</head>
<body>


<aside class="sidebar">
    <div class="logo">
        Imagine Works
    </div>

    <div class="menu-title">
        Main Menu
    </div>

    <nav class="menu">

        <a href="dashboard.php">
            Dashboard
        </a>

        <a href="site_content.php">
            Site Content
        </a>

        <a href="services.php" class="active">
            Services
        </a>

        <a href="service_details.php">
            Service Details
        </a>

        <a href="projects.php">
            Projects
        </a>

        <a href="messages.php">
            Messages
        </a>
    </nav>

    <div class="logout">

        <a href="logout.php">
            Logout
        </a>

    </div>
</aside>


<main class="main">
    <div class="page-header">

        <h1>Add Service</h1>

        <p>
            Add a main service to your Imagine Works website.
        </p>
    </div>


    <div class="form-box">

        <?php if ($error !== ""): ?>

            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>


        <form method="POST">
            <div class="form-group">
                <label for="service_name">
                    Service Name *
                </label>

                <input
                    type="text"
                    id="service_name"
                    name="service_name"
                    placeholder="Example: Software Company"
                    required
                >

            </div>

            <div class="form-group">
                <label for="short_description">
                    Short Description
                </label>

                <textarea
                    id="short_description"
                    name="short_description"
                    placeholder="Enter a short description for this service..."
                ></textarea>

            </div>


            <div class="form-group">
                <label for="icon">
                    Icon
                </label>

                <input
                    type="text"
                    id="icon"
                    name="icon"
                    placeholder="Example: fa-code"
                >

                <span class="hint">
                    You can leave this empty for now.
                </span>
            </div>


            <div class="form-group">
                <label for="image">
                    Image
                </label>

                <input
                    type="text"
                    id="image"
                    name="image"
                    placeholder="Example: img/software.jpg"
                >

                <span class="hint">
                    Enter the image path. Leave empty if you don't need an image.
                </span>
            </div>


            <div class="form-group">
                <label for="display_order">
                    Display Order
                </label>

                <input
                    type="number"
                    id="display_order"
                    name="display_order"
                    value="0"
                    min="0"
                >

                <span class="hint">
                    Lower numbers appear first.
                </span>
            </div>


            <div class="form-group checkbox-group">
                <input
                    type="checkbox"
                    id="status"
                    name="status"
                    checked
                >

                <label for="status">
                    Active
                </label>
            </div>


            <div class="buttons">
                <button
                    type="submit"
                    class="btn save-btn"
                >
                    Save Service
                </button>

                <a
                    href="services.php"
                    class="btn cancel-btn"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>
</main>
</body>
</html>