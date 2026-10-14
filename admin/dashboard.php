<?php
require_once "auth.php";
require_once "../config/db.php";

/*--Get dashboard counts--*/
$services_count = 0;
$projects_count = 0;
$messages_count = 0;
$details_count = 0;

/*--Services--*/
$result = $conn->query("SELECT COUNT(*) AS total FROM services");
if ($result)
    {
    $row = $result->fetch_assoc();
    $services_count = $row['total'];
    }


/*--Projects--*/
$result = $conn->query("SELECT COUNT(*) AS total FROM projects");
if ($result) 
    {
    $row = $result->fetch_assoc();
    $projects_count = $row['total'];
    }



/*--Messages--*/
$result = $conn->query("SELECT COUNT(*) AS total FROM messages");
if ($result) 
    {
    $row = $result->fetch_assoc();
    $messages_count = $row['total'];
    }


/*--Service Details--*/
$result = $conn->query("SELECT COUNT(*) AS total FROM service_details");
if ($result) 
    {
    $row = $result->fetch_assoc();
    $details_count = $row['total'];
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard | Imagine Works</title>

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

        /*--SIDEBAR--*/
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
            transition: 0.2s;
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

        /*--MAIN--*/
        .main 
        {
            margin-left: 250px;
            padding: 35px;
        }

        .topbar 
        {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
        }

        .topbar h1 
        {
            font-size: 30px;
        }

        .admin-name 
        {
            color: #aaaaaa;
        }


        /*--STAT CARDS--*/
        .stats 
        {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 35px;
        }

        .stat-card 
        {
            background: #181818;
            border: 1px solid #292929;
            border-radius: 12px;
            padding: 25px;
        }

        .stat-card h3 
        {
            font-size: 15px;
            color: #aaaaaa;
            margin-bottom: 15px;
        }

        .stat-number 
        {
            font-size: 32px;
            font-weight: bold;
            color: #A855F7;
        }


        /*-- MANAGEMENT--*/
        .section-title 
        {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .management 
        {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .management-card 
        {
            background: #181818;
            border: 1px solid #292929;
            border-radius: 12px;
            padding: 25px;
        }

        .management-card h3 
        {
            font-size: 19px;
            margin-bottom: 10px;
        }

        .management-card p 
        {
            color: #999999;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .manage-btn 
        {
            display: inline-block;
            text-decoration: none;
            background: #A855F7;
            color: #ffffff;
            padding: 10px 18px;
            border-radius: 7px;
        }

        .manage-btn:hover 
        {
            opacity: 0.85;
        }


        /*--RESPONSIVE--*/
        @media (max-width: 1000px) 
        {

            .stats 
            {
                grid-template-columns: repeat(2, 1fr);
            }

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

            .stats 
            {
                grid-template-columns: 1fr;
            }

            .management 
            {
                grid-template-columns: 1fr;
            }

        }

    </style>
</head>
<body>


<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="logo">
        Imagine Works
    </div>

    <div class="menu-title">
        Main Menu
    </div>

    <nav class="menu">
        <a href="dashboard.php" class="active">
            Dashboard
        </a>

        <a href="site_content.php">
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


<!-- MAIN CONTENT -->
<main class="main">
    <div class="topbar">
        <div>
            <h1>Dashboard</h1>

            <p class="admin-name">
                Welcome back,
                <?php echo htmlspecialchars($_SESSION['admin_username']); ?>
            </p>
        </div>
    </div>


    <!-- STATISTICS -->
    <div class="stats">
        <div class="stat-card">

            <h3>Total Services</h3>

            <div class="stat-number">
                <?php echo $services_count; ?>
            </div>
        </div>


        <div class="stat-card">
            <h3>Service Details</h3>
            <div class="stat-number">
                <?php echo $details_count; ?>
            </div>
        </div>


        <div class="stat-card">
            <h3>Total Projects</h3>
            <div class="stat-number">
                <?php echo $projects_count; ?>
            </div>
        </div>


        <div class="stat-card">
            <h3>Total Messages</h3>
            <div class="stat-number">
                <?php echo $messages_count; ?>
            </div>
        </div>
    </div>


    <!-- MANAGEMENT -->
    <h2 class="section-title">
        Manage Website
    </h2>

    <div class="management">
        <div class="management-card">
            <h3>Site Content</h3>
            <p>
                Manage your Home, About, CTA, contact information
                and other editable website content.
            </p>
            <a href="site_content.php" class="manage-btn">
                Manage Content
            </a>
        </div>

        <div class="management-card">
            <h3>Services</h3>
            <p>
                Add, edit, delete and control your four main
                services.
            </p>
            <a href="services.php" class="manage-btn">
                Manage Services
            </a>
        </div>


        <div class="management-card">
            <h3>Service Details</h3>
            <p>
                Manage the individual services and information
                under each main service.
            </p>
            <a href="service_details.php" class="manage-btn">
                Manage Details
            </a>
        </div>


        <div class="management-card">
            <h3>Projects</h3>
            <p>
                Add and manage your portfolio projects and
                choose featured projects for the homepage.
            </p>
            <a href="projects.php" class="manage-btn">
                Manage Projects
            </a>
        </div>


        <div class="management-card">
            <h3>Messages</h3>
            <p>
                View and manage messages received from your
                website contact form.
            </p>
            <a href="messages.php" class="manage-btn">
                View Messages
            </a>
        </div>
    </div>
</main>
</body>
</html>