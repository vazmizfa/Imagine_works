<?php
require_once "auth.php";
require_once "../config/db.php";
$query = "
    SELECT 
        sd.detail_id,
        sd.detail_name,
        sd.description,
        sd.display_order,
        sd.status,
        s.service_name
    FROM service_details sd
    INNER JOIN services s
        ON sd.service_id = s.service_id
    ORDER BY s.service_id ASC, sd.display_order ASC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Service Details | Imagine Works</title>

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
            width: 92%;
            max-width: 1300px;
            margin: 40px auto;
        }

        .top-bar 
        {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .top-bar h1 
        {
            font-size: 30px;
        }

        .back-btn 
        {
            text-decoration: none;
            color: white;
            background: #A855F7;
            padding: 12px 20px;
            border-radius: 8px;
        }

        .table-box 
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
            color: #A855F7;
            font-size: 14px;
        }

        td 
        {
            color: #ddd;
        }

        tr:last-child td 
        {
            border-bottom: none;
        }

        .status-active 
        {
            color: #6ee7b7;
        }

        .status-inactive 
        {
            color: #f87171;
        }

        .edit-btn,
        .delete-btn 
        {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            margin-right: 5px;
        }

        .edit-btn 
        {
            background: #A855F7;
            color: white;
        }

        .delete-btn 
        {
            background: #351515;
            color: #ff8c8c;
        }

        .empty 
        {
            padding: 30px;
            text-align: center;
            color: #999;
        }

    </style>
</head>
<body>

<div class="container">
    <div class="top-bar">
        <h1>Service Details</h1>
        <div style="display: flex; gap: 10px;">
    <a href="service_detail_add.php"
       class="back-btn">
        + Add Service Detail
    </a>

    <a href="dashboard.php"
       class="back-btn">
        ← Dashboard
    </a>
</div>
    </div>


    <div class="table-box">
        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Main Service</th>
                        <th>Sub-Service</th>
                        <th>Display Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($detail = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php echo $detail['detail_id']; ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($detail['service_name']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($detail['detail_name']); ?>
                            </td>

                            <td>
                                <?php echo $detail['display_order']; ?>
                            </td>

                            <td>

                                <?php if ($detail['status'] == 1): ?>

                                    <span class="status-active">
                                        Active
                                    </span>

                                <?php else: ?>

                                    <span class="status-inactive">
                                        Inactive
                                    </span>

                                <?php endif; ?>

                            </td>
                            <td>

                                <a
                                    href="service_detail_edit.php?id=<?php echo $detail['detail_id']; ?>"
                                    class="edit-btn"
                                >
                                    Edit
                                </a>

                                <a
                                    href="service_detail_delete.php?id=<?php echo $detail['detail_id']; ?>"
                                    class="delete-btn"
                                    onclick="return confirm('Are you sure you want to delete this service detail?');"
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
                No service details found.
            </div>

        <?php endif; ?>

    </div>
</div>
</body>
</html>