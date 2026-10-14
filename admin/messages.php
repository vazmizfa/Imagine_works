<?php
require_once "auth.php";
require_once "../config/db.php";

$query = "
    SELECT *
    FROM messages
    ORDER BY created_at DESC, message_id DESC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Messages | Imagine Works</title>

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

        .table-container 
        {
            background: #181818;
            border: 1px solid #2b2b2b;
            border-radius: 12px;
            overflow-x: auto;
        }

        table 
        {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td 
        {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #2b2b2b;
        }

        th 
        {
            background: #202020;
            color: #A855F7;
        }

        td 
        {
            color: #ddd;
        }

        tr:hover 
        {
            background: #202020;
        }

        .action-btn 
        {
            text-decoration: none;
            padding: 7px 12px;
            border-radius: 6px;
            font-size: 13px;
            margin-right: 5px;
        }

        .view-btn 
        {
            background: #A855F7;
            color: white;
        }

        .delete-btn 
        {
            background: #8b1e1e;
            color: white;
        }

        .empty 
        {
            padding: 30px;
            text-align: center;
            color: #aaa;
        }

    </style>
</head>
<body>
<div class="top-bar">
    <h1>Messages</h1>
    <a href="dashboard.php" class="back-btn">
        ← Dashboard
    </a>
</div>


<div class="table-container">
    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>

                    <th>Name</th>

                    <th>Email</th>

                    <th>Subject</th>

                    <th>Date</th>

                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php while ($message = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php echo $message["message_id"]; ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($message["name"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($message["email"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($message["subject"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($message["created_at"]); ?>
                        </td>
                        <td>

                            <a
                                href="message_view.php?id=<?php echo $message["message_id"]; ?>"
                                class="action-btn view-btn"
                            >
                                View
                            </a>

                            <a
                                href="message_delete.php?id=<?php echo $message["message_id"]; ?>"
                                class="action-btn delete-btn"
                                onclick="return confirm('Are you sure you want to delete this message?');"
                            >
                                Delete
                            </a>
                        </td>
                    </tr>

                <?php endwhile; ?>
            </tbody>
        </table>

    <?php else: ?>

        <div class="empty">
            No messages available.
        </div>

    <?php endif; ?>
</div>
</body>
</html>