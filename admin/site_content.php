<?php
require_once "auth.php";
require_once "../config/db.php";

/*--UPDATE CONTENT--*/
if (isset($_POST['update_content'])) {

    $content_id = intval($_POST['content_id']);
    $content_value = trim($_POST['content_value']);
    $status = isset($_POST['status']) ? 1 : 0;

    $stmt = $conn->prepare("
        UPDATE site_content
        SET content_value = ?, status = ?, updated_at = NOW()
        WHERE content_id = ?
    ");

    $stmt->bind_param(
        "sii",
        $content_value,
        $status,
        $content_id
    );

    $stmt->execute();
    $stmt->close();

    header("Location: site_content.php?updated=1");
    exit;
}


/*--UPLOAD IMAGE--*/
if (isset($_POST['upload_image'])) {

    $content_id = intval($_POST['content_id']);

    if (isset($_FILES['content_image']) && $_FILES['content_image']['error'] === UPLOAD_ERR_OK) {

        $file = $_FILES['content_image'];

        $allowed_extensions = [
            'jpg',
            'jpeg',
            'png',
            'webp',
            'gif'
        ];

        $extension = strtolower(
            pathinfo($file['name'], PATHINFO_EXTENSION)
        );


        /*--Check extension--*/
        if (!in_array($extension, $allowed_extensions)) {

            header("Location: site_content.php?error=invalid_image");
            exit;
        }


        /*--Check size - 5 MB--*/
        if ($file['size'] > 5 * 1024 * 1024) {

            header("Location: site_content.php?error=large_image");
            exit;
        }


        /*--Upload folder--*/

        $upload_folder = "../img/";

        if (!is_dir($upload_folder)) {

            mkdir($upload_folder, 0777, true);
        }


        /*--Unique filename--*/
        $filename =
            "hero_" .
            time() .
            "_" .
            uniqid() .
            "." .
            $extension;


        $target_file = $upload_folder . $filename;

        /*--Move uploaded file--*/
        if (move_uploaded_file(
            $file['tmp_name'],
            $target_file
        )) {

            /*
             * Path stored in database
             *
             * Example:
             * img/hero_123456_xxxxx.jpg
             */

            $image_path = "img/" . $filename;


            $stmt = $conn->prepare("
                UPDATE site_content
                SET content_value = ?,
                    updated_at = NOW()
                WHERE content_id = ?
            ");

            $stmt->bind_param(
                "si",
                $image_path,
                $content_id
            );

            $stmt->execute();

            $stmt->close();


            header("Location: site_content.php?image_uploaded=1");
            exit;

        } else {

            header("Location: site_content.php?error=upload_failed");
            exit;
        }

    } else {

        header("Location: site_content.php?error=no_image");
        exit;
    }
}


/*--GET ALL CONTENT--*/
$content_query = "
    SELECT *
    FROM site_content
    ORDER BY section_name ASC, display_order ASC, content_id ASC
";

$content_result = $conn->query($content_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Site Content | Imagine Works</title>

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

        .menu a:hover 
        {
            background: #242424;
            color: #ffffff;
        }

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

        .logout a:hover 
        {
            background: #A855F7;
        }

        .main 
        {
            margin-left: 250px;
            padding: 35px;
        }

        .topbar 
        {
            margin-bottom: 30px;
        }

        .topbar h1 
        {
            font-size: 30px;
            margin-bottom: 8px;
        }

        .topbar p 
        {
            color: #999999;
        }


        .success 
        {
            background: #163d24;
            border: 1px solid #246b3c;
            color: #8ff0aa;
            padding: 13px 16px;
            border-radius: 8px;
            margin-bottom: 25px;
        }


        .error 
        {
            background: #4a1717;
            border: 1px solid #702020;
            color: #ffaaaa;
            padding: 13px 16px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .content-card 
        {
            background: #181818;
            border: 1px solid #292929;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .section-heading
        {
            font-size: 21px;
            color: #A855F7;
            margin-bottom: 20px;
            text-transform: capitalize;
        }

        .content-item 
        {
            border-top: 1px solid #292929;
            padding: 20px 0;
        }

        .content-item:first-child 
        {
            border-top: none;
            padding-top: 0;
        }

        .content-key 
        {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 7px;
        }

        .content-type 
        {
            color: #777777;
            font-size: 12px;
            margin-bottom: 12px;
        }

        input[type="text"],
        textarea 
        {
            width: 100%;
            background: #101010;
            color: #ffffff;
            border: 1px solid #333333;
            border-radius: 7px;
            padding: 12px;
            font-size: 14px;
            outline: none;
        }

        textarea 
        {
            min-height: 110px;
            resize: vertical;
        }

        input[type="text"]:focus,
        textarea:focus 
        {
            border-color: #A855F7;
        }


        input[type="file"] 
        {
            width: 100%;
            background: #101010;
            color: #ffffff;
            border: 1px solid #333333;
            border-radius: 7px;
            padding: 10px;
            font-size: 14px;
            margin-bottom: 12px;
        }

        input[type="file"]:focus 
        {
            border-color: #A855F7;
        }


        .image-preview 
        {
            margin-bottom: 15px;
        }

        .image-preview p 
        {
            color: #aaaaaa;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .image-preview img 
        {
            width: 220px;
            height: 130px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #333333;
            display: block;
        }

        .content-actions 
        {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 12px;
        }

        .status-label 
        {
            color: #aaaaaa;
            font-size: 14px;
        }

        .status-label input 
        {
            margin-right: 7px;
        }

        .save-btn 
        {
            border: none;
            background: #A855F7;
            color: #ffffff;
            padding: 10px 18px;
            border-radius: 7px;
            cursor: pointer;
            font-size: 14px;
        }

        .save-btn:hover 
        {
            opacity: 0.85;
        }

        .empty 
        {
            color: #999999;
            padding: 20px 0;
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

            .content-actions 
            {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
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

        <a href="site_content.php" class="active">
            Site Content
        </a>

        <a href="services.php">
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


/*--MAIN--*/

<main class="main">
    <div class="topbar">
        <h1>Site Content</h1>

        <p>
            Manage the content displayed on your Imagine Works website.
        </p>
    </div>


    <?php if (isset($_GET['updated'])): ?>
        <div class="success">
            Content updated successfully.
        </div>
    <?php endif; ?>


    <?php if (isset($_GET['image_uploaded'])): ?>
        <div class="success">
            Image uploaded successfully.
        </div>

    <?php endif; ?>


    <?php if (isset($_GET['error'])): ?>
        <div class="error">

            <?php
            if ($_GET['error'] === 'invalid_image') {

                echo "Only JPG, JPEG, PNG, WEBP and GIF images are allowed.";

            } elseif ($_GET['error'] === 'large_image') {

                echo "Image size must be less than 5 MB.";

            } elseif ($_GET['error'] === 'no_image') {

                echo "Please select an image.";

            } else {

                echo "Image upload failed.";

            }

            ?>
        </div>
    <?php endif; ?>


    <?php
    $current_section = "";
    if ($content_result && $content_result->num_rows > 0):

        while ($content = $content_result->fetch_assoc()):

            $section = $content['section_name'];

            if ($current_section !== $section):

                if ($current_section !== ""):
                    echo '</div>';
                endif;

                $current_section = $section;

            ?>

                <div class="content-card">
                    <div class="section-heading">
                        <?php echo htmlspecialchars($section); ?>
                    </div>
            <?php endif; ?>


            <div class="content-item">
                <div class="content-key">

                    <?php

                    echo htmlspecialchars(
                        ucwords(
                            str_replace(
                                "_",
                                " ",
                                $content['content_key']
                            )
                        )
                    );

                    ?>
                </div>

                <div class="content-type">

                    Type:
                    <?php echo htmlspecialchars($content['content_type']); ?>

                </div>


                <!--IMAGE CONTENT-->

                <?php if ($content['content_type'] === 'image'): ?>

                    <form
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        <input
                            type="hidden"
                            name="content_id"
                            value="<?php echo $content['content_id']; ?>"
                        >


                        <?php if (!empty($content['content_value'])): ?>
                            <div class="image-preview">
                                <p>Current Image:</p>

                                <img
                                    src="../<?php echo htmlspecialchars($content['content_value']); ?>"
                                    alt="Current Image"
                                >

                            </div>
                        <?php endif; ?>


                        <input
                            type="file"
                            name="content_image"
                            accept=".jpg,.jpeg,.png,.webp,.gif"
                            required
                        >


                        <div class="content-actions">
                            <label class="status-label">
                                <input
                                    type="checkbox"
                                    name="status"
                                    value="1"
                                    <?php echo ($content['status'] == 1) ? 'checked' : ''; ?>
                                >

                                Active
                            </label>


                            <button
                                type="submit"
                                name="upload_image"
                                class="save-btn"
                            >

                                Upload Image

                            </button>
                        </div>
                    </form>


                    <!--TEXT CONTENT-->
              

                <?php else: ?>

                    <form method="POST">
                        <input
                            type="hidden"
                            name="content_id"
                            value="<?php echo $content['content_id']; ?>"
                        >


                        <?php if ($content['content_type'] === 'textarea'): ?>

                            <textarea
                                name="content_value"
                            ><?php echo htmlspecialchars($content['content_value']); ?></textarea>


                        <?php else: ?>

                            <input
                                type="text"
                                name="content_value"
                                value="<?php echo htmlspecialchars($content['content_value']); ?>"
                            >


                        <?php endif; ?>


                        <div class="content-actions">
                            <label class="status-label">
                                <input
                                    type="checkbox"
                                    name="status"
                                    value="1"
                                    <?php echo ($content['status'] == 1) ? 'checked' : ''; ?>
                                >

                                Active
                            </label>


                            <button
                                type="submit"
                                name="update_content"
                                class="save-btn"
                            >

                                Save Changes

                            </button>
                        </div>
                    </form>


                <?php endif; ?>

            </div>

        <?php endwhile; ?>

        </div>

    <?php else: ?>

        <div class="content-card">
            <div class="empty">
                No site content found in the database.
            </div>
        </div>

    <?php endif; ?>

</main>
</body>
</html>