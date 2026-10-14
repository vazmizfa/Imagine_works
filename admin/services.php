<?php
require_once "auth.php";
require_once "../config/db.php";
$sql = "SELECT * FROM services ORDER BY display_order ASC, service_id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Services | Imagine Works</title>

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
        }

        .page-header 
        {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-header h1 
        {
            font-size: 30px;
        }

        .add-btn 
        {
            background: #A855F7;
            color: white;
            text-decoration: none;
            padding: 11px 18px;
            border-radius: 7px;
        }

        .table-container 
        {
            background: #181818;
            border: 1px solid #292929;
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
            border-bottom: 1px solid #292929;
        }

        th 
        {
            color: #aaaaaa;
            font-size: 14px;
        }

        td 
        {
            color: #eeeeee;
        }

        .status 
        {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .active-status 
        {
            background: #173b25;
            color: #6ee7a0;
        }

        .inactive-status 
        {
            background: #3b2020;
            color: #ff9999;
        }

        .action-btn 
        {
            text-decoration: none;
            padding: 7px 11px;
            border-radius: 5px;
            margin-right: 5px;
            font-size: 13px;
        }

        .edit 
        {
            background: #333333;
            color: white;
        }

        .details 
        {
            background: #A855F7;
            color: white;
        }

        .delete 
        {
            background: #492020;
            color: #ffaaaa;
        }

        .empty 
        {
            text-align: center;
            padding: 40px;
            color: #888888;
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
        <h1>Services</h1>

        <a href="service_add.php" class="add-btn">
            + Add Service
        </a>
    </div>


    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Service Name</th>
                    <th>Description</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>


            <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($service = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php echo $service['service_id']; ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($service['service_name']); ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                mb_strimwidth(
                                    $service['short_description'] ?? '',
                                    0,
                                    60,
                                    '...'
                                )
                            );
                            ?>
                        </td>

                        <td>
                            <?php echo $service['display_order']; ?>
                        </td>

                        <td>
                            <?php if ($service['status'] == 1): ?>

                                <span class="status active-status">
                                    Active
                                </span>

                            <?php else: ?>

                                <span class="status inactive-status">
                                    Inactive
                                </span>

                            <?php endif; ?>
                        </td>

                        <td>
                            <a
                                href="service_edit.php?id=<?php echo $service['service_id']; ?>"
                                class="action-btn edit"
                            >
                                Edit
                            </a>

                            <a
                                href="service_details.php?service_id=<?php echo $service['service_id']; ?>"
                                class="action-btn details"
                            >
                                Details
                            </a>

                            <a
                                href="service_delete.php?id=<?php echo $service['service_id']; ?>"
                                class="action-btn delete"
                                onclick="return confirm('Are you sure you want to delete this service?');"
                            >
                                Delete
                            </a>
                        </td>
                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>
                    <td colspan="6" class="empty">

                        No services added yet.

                    </td>
                </tr>

            <?php endif; ?>

            </tbody>
        </table>
    </div>
</main>
</body>
</html>