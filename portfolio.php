<?php
require_once "config/db.php";

/*--ALL PROJECTS--*/
$projects_query = "
    SELECT *
    FROM projects
    WHERE status = 1
    ORDER BY display_order ASC, project_id ASC
";

$projects_result = $conn->query($projects_query);
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Portfolio | Imagine Works</title>

    <link rel="stylesheet" href="css/style.css">

</head>


<body>


<!--NAVBAR-->
<header>

    <nav class="navbar">

        <div class="logo">
            Imagine<span>Works</span>
        </div>


        <ul class="nav-links">

            <li>
                <a href="index.php#home">
                    Home
                </a>
            </li>

            <li>
                <a href="index.php#about">
                    About
                </a>
            </li>

            <li>
                <a href="index.php#services">
                    Services
                </a>
            </li>

            <li>
                <a href="portfolio.php">
                    Portfolio
                </a>
            </li>

            <li>
                <a href="index.php#contact">
                    Contact
                </a>
            </li>

        </ul>


        <a
            href="index.php#contact"
            class="contact-btn"
        >
            Let's Talk
        </a>
    </nav>
</header>



<!--FULL PORTFOLIO-->
<section class="full-portfolio">
    <div class="section-heading">

        <p class="subtitle">
            ALL PROJECTS
        </p>


        <h2>
            Explore Our <span>Projects</span>
        </h2>


        <p class="section-description">
            Take a look at our complete collection of
            creative and digital work.
        </p>
    </div>



    <div class="full-project-container">

        <?php if (
            $projects_result &&
            $projects_result->num_rows > 0
        ): ?>


            <?php while (
                $project = $projects_result->fetch_assoc()
            ): ?>


                <div class="full-project-card">


                    <!--IMAGE BOX-->
                    <div class="full-project-image">
                        <?php if (!empty($project['image'])): ?>

                            <img
                                src="<?php echo htmlspecialchars(
                                    $project['image']
                                ); ?>"
                                alt="<?php echo htmlspecialchars(
                                    $project['project_name']
                                ); ?>"
                            >

                        <?php else: ?>

                            <span>
                                <?php echo htmlspecialchars(
                                    $project['project_name']
                                ); ?>
                            </span>

                        <?php endif; ?>

                    </div>



                    <!--PROJECT INFORMATION -->

                    <div class="full-project-content">

                        <p class="project-category">

                            <?php echo htmlspecialchars(
                                $project['category']
                            ); ?>

                        </p>


                        <h3>

                            <?php echo htmlspecialchars(
                                $project['project_name']
                            ); ?>

                        </h3>


                    <p>
                        <?php echo htmlspecialchars(
                            $project['short_description']
                        ); ?>
                    </p>
                    </div>
                </div>


            <?php endwhile; ?>


        <?php else: ?>


            <p class="no-projects">

                No projects available at the moment.

            </p>


        <?php endif; ?>


    </div>
</section>



<!--CTA-->
<section class="cta">
    <p class="subtitle">
        HAVE AN IDEA?
    </p>


    <h2>
        Let's turn your
        <span>idea into reality.</span>
    </h2>


    <p>
        Let's work together to create something
        meaningful and effective.
    </p>


    <a
        href="index.php#contact"
        class="primary-btn"
    >
        Start a Project →
    </a>
</section>


<!--FOOTER-->

<footer>
    <div class="footer-logo">
        Imagine<span>Works</span>
    </div>


    <p>
        Imagine. Create. Make it Work.
    </p>


    <div class="footer-links">

        <a href="index.php#home">
            Home
        </a>

        <a href="index.php#about">
            About
        </a>

        <a href="index.php#services">
            Services
        </a>

        <a href="portfolio.php">
            Portfolio
        </a>

        <a href="index.php#contact">
            Contact
        </a>

    </div>


    <p class="copyright">
        © 2026 Imagine Works.
        All Rights Reserved.
    </p>
</footer>
<script src="js/script.js"></script>
</body>
</html>