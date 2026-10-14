<?php
require_once "auth.php";
require_once "../config/db.php";

/* Get all projects */
$query = "
    SELECT *
    FROM projects
    ORDER BY display_order ASC, project_id DESC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Projects | Imagine Works</title>

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
            max-width: 1200px;
            margin: 40px auto;
        }

        .top-bar 
        {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            gap: 20px;
        }

        h1 
        {
            font-size: 30px;
        }

        .buttons 
        {
            display: flex;
            gap: 10px;
        }

        .btn 
        {
            text-decoration: none;
            padding: 11px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
        }

        .add-btn 
        {
            background: #A855F7;
            color: white;
        }

        .dashboard-btn 
        {
            background: #222;
            color: white;
            border: 1px solid #333;
        }

        .table-box 
        {
            background: #181818;
            border: 1px solid #2b2b2b;
            border-radius: 15px;
            overflow-x: auto;
        }

        table 
        {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        th,
        td 
        {
            padding: 15px;
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
            font-size: 14px;
        }

        tr:last-child td 
        {
            border-bottom: none;
        }

        .status-active 
        {
            color: #6ee7b7;
            font-weight: bold;
        }

        .status-inactive 
        {
            color: #ff8c8c;
            font-weight: bold;
        }

        .featured 
        {
            color: #A855F7;
            font-weight: bold;
        }

        .not-featured 
        {
            color: #777;
        }

        .actions 
        {
            display: flex;
            gap: 8px;
        }

        .edit-btn,
        .delete-btn 
        {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
        }

        .edit-btn 
        {
            background: #252525;
            color: white;
            border: 1px solid #444;
        }

        .delete-btn 
        {
            background: #351515;
            color: #ff8c8c;
        }

        .empty 
        {
            text-align: center;
            padding: 40px;
            color: #888;
        }

        @media (max-width: 700px) 
        {

            .top-bar 
            {
                flex-direction: column;
                align-items: flex-start;
            }

        }

    </style>
</head>
<body>

<div class="container">
    <div class="top-bar">
        <h1>Projects</h1>
        <div class="buttons">
            <a href="project_add.php" class="btn add-btn">
                + Add Project
            </a>

            <a href="dashboard.php" class="btn dashboard-btn">
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

                        <th>Project Name</th>

                        <th>Category</th>

                        <th>Featured</th>

                        <th>Display Order</th>

                        <th>Status</th>

                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php while ($project = $result->fetch_assoc()): ?>

                        <tr>
                            <td>
                                <?php echo $project["project_id"]; ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($project["project_name"]); ?>
                            </td>

                            <td>
                                <?php
                                echo !empty($project["category"])
                                    ? htmlspecialchars($project["category"])
                                    : "—";
                                ?>
                            </td>
                            <td>

                                <?php if ($project["featured"] == 1): ?>

                                    <span class="featured">
                                        Yes
                                    </span>

                                <?php else: ?>

                                    <span class="not-featured">
                                        No
                                    </span>

                                <?php endif; ?>

                            </td>
                            <td>
                                <?php echo $project["display_order"]; ?>
                            </td>
                            <td>

                                <?php if ($project["status"] == 1): ?>

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

                                <div class="actions">

                                    <a
                                        href="project_edit.php?id=<?php echo $project["project_id"]; ?>"
                                        class="edit-btn"
                                    >
                                        Edit
                                    </a>

                                    <a
                                        href="project_delete.php?id=<?php echo $project["project_id"]; ?>"
                                        class="delete-btn"
                                        onclick="return confirm('Are you sure you want to delete this project?');"
                                    >
                                        Delete
                                    </a>

                                </div>
                            </td>
                        </tr>

                    <?php endwhile; ?>

                </tbody>
            </table>

        <?php else: ?>

            <div class="empty">
                No projects found.
            </div>

        <?php endif; ?>

    </div>
</div>
</body>
</html>