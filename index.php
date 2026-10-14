<?php

require_once "config/db.php";


/*--SITE CONTENT--*/

$site_content = [];

$content_query = "
    SELECT content_key, content_value
    FROM site_content
    WHERE status = 1
    ORDER BY display_order ASC
";

$content_result = $conn->query($content_query);

if ($content_result) {

    while ($content = $content_result->fetch_assoc()) {

        $site_content[$content['content_key']] = $content['content_value'];

    }

}


/*--SERVICES--*/

$services_query = "
    SELECT *
    FROM services
    WHERE status = 1
    ORDER BY display_order ASC, service_id ASC
";

$services_result = $conn->query($services_query);


/*--FEATURED PROJECTS--*/

$featured_projects_query = "
    SELECT *
    FROM projects
    WHERE status = 1
    AND featured = 1
    ORDER BY display_order ASC, project_id ASC
    LIMIT 3
";

$featured_projects_result = $conn->query($featured_projects_query);

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Imagine Works</title>

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
                <a href="#home">
                    Home
                </a>
            </li>

            <li>
                <a href="#about">
                    About
                </a>
            </li>

            <li>
                <a href="#services">
                    Services
                </a>
            </li>

            <li>
                <a href="#portfolio">
                    Portfolio
                </a>
            </li>

            <li>
                <a href="#contact">
                    Contact
                </a>
            </li>

        </ul>


        <a href="#contact"
           class="contact-btn">

            Let's Talk

        </a>

        <a href="admin/login.php"
            class="contact-btn">
             Login</a>

    </nav>

</header>



<!--HERO SECTION-->

<section class="hero" id="home">


    <div class="hero-content">

        <p class="subtitle">

            <?php
            echo htmlspecialchars(
                $site_content['subtitle']
                ?? 'CREATIVE DIGITAL STUDIO'
            );
            ?>

        </p>


        <h1>

            <?php
            echo htmlspecialchars(
                $site_content['title_line_1']
                ?? 'We Imagine.'
            );
            ?>

            <br>


            <?php
            echo htmlspecialchars(
                $site_content['title_line_2']
                ?? 'We Create.'
            );
            ?>

            <br>


            <span>

                <?php
                echo htmlspecialchars(
                    $site_content['title_line_3']
                    ?? 'We Make It Work.'
                );
                ?>

            </span>

        </h1>


        <p class="description">

            <?php
            echo htmlspecialchars(
                $site_content['description']
                ?? 'Imagine Works creates modern digital experiences, creative designs and innovative solutions that help brands stand out in the digital world.'
            );
            ?>

        </p>


        <div class="hero-buttons">

            <a href="#portfolio"
               class="primary-btn">

                View Our Work →

            </a>


            <a href="#services"
               class="secondary-btn">

                Explore Services

            </a>

        </div>

    </div>



    <!-- ONE HOME PAGE IMAGE -->

    <div class="hero-image">

        <div class="image-box">


            <?php if (
                !empty($site_content['hero_image'])
            ): ?>

                <img
                    src="<?php
                        echo htmlspecialchars(
                            $site_content['hero_image']
                        );
                    ?>"
                    alt="Imagine Works"
                >


            <?php else: ?>

                <div class="image-placeholder">

                    IMAGINE<br>
                    WORKS

                </div>

            <?php endif; ?>


        </div>

    </div>


</section>



<!--ABOUT SECTION -->

<section class="about" id="about">


    <div class="about-content">

        <p class="subtitle">

            ABOUT IMAGINE WORKS

        </p>


        <h2>

            Turning ideas into
            <span>digital experiences.</span>

        </h2>


        <p>

            Imagine Works is a creative digital studio focused on
            building meaningful digital experiences for businesses,
            organisations and individuals.

        </p>


        <p>

            We combine creativity and technology to transform ideas
            into effective digital solutions.

        </p>

    </div>


</section>



<!--SERVICES-->

<section class="services" id="services">


    <div class="section-heading">

        <p class="subtitle">

            WHAT WE DO

        </p>


        <h2>

            Our<span>Services</span>

        </h2>


        <p class="section-description">

            Explore the different services offered by
            Imagine Works.

        </p>

    </div>



    <div class="service-container">


        <?php if (
            $services_result &&
            $services_result->num_rows > 0
        ): ?>


            <?php while (
                $service = $services_result->fetch_assoc()
            ): ?>


                <div class="service-card">


                    <span class="service-number">

                        <?php
                        echo str_pad(
                            $service['display_order'],
                            2,
                            '0',
                            STR_PAD_LEFT
                        );
                        ?>

                    </span>


                    <h3>

                        <?php
                        echo htmlspecialchars(
                            $service['service_name']
                        );
                        ?>

                    </h3>


                    <p>

                        <?php
                        echo htmlspecialchars(
                            $service['short_description']
                        );
                        ?>

                    </p>


                    <a
                        href="services/<?php

                            if ($service['service_id'] == 1) {

                                echo 'software.php';

                            } elseif ($service['service_id'] == 2) {

                                echo 'hosting.php';

                            } elseif ($service['service_id'] == 3) {

                                echo 'internet.php';

                            } elseif ($service['service_id'] == 4) {

                                echo 'computerservices.php';

                            }

                        ?>"
                        class="service-btn"
                    >

                        Explore Services →

                    </a>


                </div>


            <?php endwhile; ?>


        <?php else: ?>


            <p>

                No services available at the moment.

            </p>


        <?php endif; ?>


    </div>


</section>



<!--PORTFOLIO-->

<section class="portfolio" id="portfolio">


    <div class="section-heading">


        <p class="subtitle">

            OUR WORK

        </p>


        <h2>

            Featured <span>Projects</span>

        </h2>


        <p class="section-description">

            Take a look at some of our creative
            digital work.

        </p>


    </div>



    <div class="project-container">


        <?php if (
            $featured_projects_result &&
            $featured_projects_result->num_rows > 0
        ): ?>


            <?php while (
                $project =
                $featured_projects_result->fetch_assoc()
            ): ?>


                <div class="project-card">


                    <!-- PROJECT IMAGE -->

                    <div class="project-image">


                        <?php if (
                            !empty($project['image'])
                        ): ?>


                            <img
                                src="<?php
                                    echo htmlspecialchars(
                                        $project['image']
                                    );
                                ?>"
                                alt="<?php
                                    echo htmlspecialchars(
                                        $project['project_name']
                                    );
                                ?>"
                            >


                        <?php else: ?>


                            <?php
                            echo htmlspecialchars(
                                $project['project_name']
                            );
                            ?>


                        <?php endif; ?>


                    </div>



                    <h3>

                        <?php
                        echo htmlspecialchars(
                            $project['project_name']
                        );
                        ?>

                    </h3>


                    <p>

                        <?php
                        echo htmlspecialchars(
                            $project['category']
                        );
                        ?>

                    </p>


                </div>


            <?php endwhile; ?>


        <?php else: ?>


            <p>

                No featured projects available at the moment.

            </p>


        <?php endif; ?>


    </div>



    <div class="portfolio-button">


        <a
            href="portfolio.php"
            class="secondary-btn"
        >

            View Full Portfolio →

        </a>


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
        href="#contact"
        class="primary-btn"
    >

        Start a Project →

    </a>


</section>



<!--CONTACT-->

<section class="contact" id="contact">


    <div class="section-heading">


        <p class="subtitle">

            GET IN TOUCH

        </p>


        <h2>

            Let's <span>Talk.</span>

        </h2>


        <p class="section-description">

            Have a project or question?
            Send us a message.

        </p>


    </div>



    <?php if (
        isset($_GET["success"]) &&
        $_GET["success"] == "1"
    ): ?>


        <div class="contact-success">

            Your message has been sent successfully!

        </div>


    <?php elseif (
        isset($_GET["error"])
    ): ?>


        <div class="contact-error">


            <?php

            if ($_GET["error"] === "required") {

                echo "Please fill in all required fields.";

            } elseif ($_GET["error"] === "email") {

                echo "Please enter a valid email address.";

            } else {

                echo "Something went wrong. Please try again.";

            }

            ?>


        </div>


    <?php endif; ?>



    <form
        class="contact-form"
        action="contact.php"
        method="POST"
    >


        <input
            type="text"
            name="name"
            placeholder="Your Name"
            required
        >


        <input
            type="email"
            name="email"
            placeholder="Your Email"
            required
        >


        <input
            type="text"
            name="subject"
            placeholder="Subject"
            required
        >


        <textarea
            name="message"
            placeholder="Tell us about your project..."
            required
        ></textarea>


        <button type="submit">

            Send Message →

        </button>


    </form>


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


        <a href="#home">

            Home

        </a>


        <a href="#about">

            About

        </a>


        <a href="#services">

            Services

        </a>


        <a href="portfolio.php">

            Portfolio

        </a>


        <a href="#contact">

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