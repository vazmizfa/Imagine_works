<?php
require_once "auth.php";
require_once "../config/db.php";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $service_id = (int) $_POST["service_id"];
    $detail_name = trim($_POST["detail_name"]);
    $description = trim($_POST["description"]);
    $display_order = (int) $_POST["display_order"];
    $status = isset($_POST["status"]) ? 1 : 0;

    if ($service_id <= 0 || $detail_name === "") {

        $error = "Please select a service and enter a sub-service name.";

    } else {

        $stmt = $conn->prepare("
            INSERT INTO service_details
            (service_id, detail_name, description, display_order, status)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "issii",
            $service_id,
            $detail_name,
            $description,
            $display_order,
            $status
        );

        if ($stmt->execute()) {

            header("Location: service_details.php");
            exit();

        } else {

            $error = "Failed to add service detail.";

        }

        $stmt->close();
    }
}


/*--Get all main services--*/

$services_result = $conn->query("
    SELECT service_id, service_name
    FROM services
    ORDER BY display_order ASC, service_id ASC
");
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Service Detail | Imagine Works</title>

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
            max-width: 700px;
            margin: 50px auto;
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
            margin-bottom: 30px;
        }

        .form-group 
        {
            margin-bottom: 20px;
        }

        label 
        {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input,
        select,
        textarea 
        {
            width: 100%;
            padding: 13px;
            border: 1px solid #333;
            border-radius: 8px;
            background: #0e0e0e;
            color: white;
            outline: none;
        }

        input:focus,
        select:focus,
        textarea:focus 
        {
            border-color: #A855F7;
        }

        textarea 
        {
            min-height: 120px;
            resize: vertical;
        }

        .checkbox 
        {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkbox input 
        {
            width: auto;
        }

        button 
        {
            width: 100%;
            padding: 13px;
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
            margin-top: 20px;
            color: #aaa;
            text-decoration: none;
        }

        .error 
        {
            background: #351515;
            color: #ff8c8c;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

    </style>
</head>
<body>

<div class="container">
    <div class="form-box">
        <h1>Add Service Detail</h1>

        <?php if ($error !== ""): ?>

            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>


        <form method="POST">
            <div class="form-group">
                <label for="service_id">
                    Main Service
                </label>
                <select name="service_id" id="service_id" required>

                    <option value="">
                        Select Main Service
                    </option>

                    <?php while ($service = $services_result->fetch_assoc()): ?>

                        <option value="<?php echo $service["service_id"]; ?>">

                            <?php echo htmlspecialchars($service["service_name"]); ?>

                        </option>

                    <?php endwhile; ?>
                </select>
            </div>


            <div class="form-group">
                <label for="detail_name">
                    Sub-Service Name
                </label>
                <input
                    type="text"
                    name="detail_name"
                    id="detail_name"
                    placeholder="Enter sub-service name"
                    required
                >

            </div>


            <div class="form-group">
                <label for="description">
                    Description
                </label>
                <textarea
                    name="description"
                    id="description"
                    placeholder="Enter description"
                ></textarea>
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
            </div>


            <div class="form-group checkbox">
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
                Add Service Detail
            </button>
        </form>


        <a href="service_details.php" class="back">
            ← Back to Service Details
        </a>

    </div>
</div>
</body>
</html>