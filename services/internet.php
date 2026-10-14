<?php
require_once "../config/db.php";
$service_id = 3;
$details_query = "
    SELECT *
    FROM service_details
    WHERE service_id = ?
    AND status = 1
    ORDER BY display_order ASC, detail_id ASC
";

$stmt = $conn->prepare($details_query);
$stmt->bind_param("i", $service_id);
$stmt->execute();

$details_result = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>INTERNET MARKETING SERVICE| Imagine Works</title>

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>


<!-- NAVBAR-->
<header>
    <nav class="navbar">
        <div class="logo">
            Imagine<span>Works</span>
        </div>

        <ul class="nav-links">

            <li>
                <a href="../index.php#home">Home</a>
            </li>

            <li>
                <a href="../index.php#about">About</a>
            </li>

            <li>
                <a href="../index.php#services">Services</a>
            </li>

            <li>
                <a href="../index.php#portfolio">Portfolio</a>
            </li>

            <li>
                <a href="../index.php#contact">Contact</a>
            </li>

        </ul>

        <a href="../index.php#contact"
           class="contact-btn">
            Let's Talk
        </a>
    </nav>
</header>

<!--SOFTWARE SERVICES-->
<section class="service-details">
    <div class="section-heading">
        <p class="subtitle">
            WHAT WE OFFER
        </p>

        <h2>
            Grow Your Business <span>online</span>
        </h2>

        <p class="section-description">
            Digital marketing solutions that help businesses
            build their online presence, reach more customers
            and grow their brand.
        </p>

    </div>



        <?php if ($details_result && $details_result->num_rows > 0): ?>

    <?php while ($detail = $details_result->fetch_assoc()): ?>

        <div class="detail-card">

            <span>
                <?php echo str_pad($detail['display_order'], 2, '0', STR_PAD_LEFT); ?>
            </span>

            <h3>
                <?php echo htmlspecialchars($detail['detail_name']); ?>
            </h3>

            <?php if (!empty($detail['description'])): ?>
                <p>
                    <?php echo htmlspecialchars($detail['description']); ?>
                </p>
            <?php endif; ?>

        </div>

    <?php endwhile; ?>

<?php else: ?>

    <p>No internet marketing services available at the moment.</p>

<?php endif; ?>