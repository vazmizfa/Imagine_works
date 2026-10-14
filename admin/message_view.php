<?php
require_once "auth.php";
require_once "../config/db.php";
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: messages.php");
    exit();
}

$message_id = (int) $_GET["id"];
$stmt = $conn->prepare("
    SELECT *
    FROM messages
    WHERE message_id = ?
    LIMIT 1
");

$stmt->bind_param("i", $message_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    $stmt->close();
    header("Location: messages.php");
    exit();
}

$message = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>View Message | Imagine Works</title>

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
            padding: 40px;
        }

        .container 
        {
            max-width: 900px;
            margin: auto;
        }

        .top-bar 
        {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h1 
        {
            font-size: 30px;
        }

        .back-btn 
        {
            text-decoration: none;
            background: #A855F7;
            color: white;
            padding: 11px 18px;
            border-radius: 8px;
            font-weight: bold;
        }

        .message-box 
        {
            background: #181818;
            border: 1px solid #2b2b2b;
            border-radius: 12px;
            padding: 30px;
        }

        .field 
        {
            margin-bottom: 25px;
        }

        .label 
        {
            color: #A855F7;
            font-size: 14px;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .value 
        {
            color: #ddd;
            font-size: 16px;
            line-height: 1.6;
            word-break: break-word;
        }

        .message-content 
        {
            white-space: pre-wrap;
        }

    </style>
</head>
<body>
<div class="container">
    <div class="top-bar">
        <h1>View Message</h1>
        <a href="messages.php" class="back-btn">
            ← Messages
        </a>
    </div>


    <div class="message-box">
        <div class="field">
            <div class="label">
                Name
            </div>
            <div class="value">
                <?php echo htmlspecialchars($message["name"]); ?>
            </div>
        </div>


        <div class="field">
            <div class="label">
                Email
            </div>
            <div class="value">
                <?php echo htmlspecialchars($message["email"]); ?>
            </div>
        </div>


        <div class="field">
            <div class="label">
                Subject
            </div>
            <div class="value">
                <?php echo htmlspecialchars($message["subject"]); ?>
            </div>
        </div>


        <div class="field">
            <div class="label">
                Date
            </div>
            <div class="value">
                <?php echo htmlspecialchars($message["created_at"]); ?>
            </div>
        </div>


        <div class="field">
            <div class="label">
                Message
            </div>
            <div class="value message-content">
                <?php echo htmlspecialchars($message["message"]); ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>