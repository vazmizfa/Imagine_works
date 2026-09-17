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


<!--NAVBAR -->

<header>
    <nav class="navbar">

        <div class="logo">
            Imagine<span>Works</span>
        </div>


        <ul class="nav-links">
            <li>
                <a href="#home">Home</a>
            </li>

            <li>
                <a href="#about">About</a>
            </li>

            <li>
                <a href="#services">Services</a>
            </li>

            <li>
                <a href="#portfolio">Portfolio</a>
            </li>

            <li>
                <a href="#contact">Contact</a>
            </li>

        </ul>

        <a href="#contact" class="contact-btn">
            Let's Talk
        </a>
    </nav>
</header>



<!--HERO SECTION-->

<section class="hero" id="home">
    <div class="hero-content">
        <p class="subtitle">
            CREATIVE DIGITAL STUDIO
        </p>

        <h1>
            We Imagine.<br>
            We Create.<br>
            <span>We Make It Work.</span>
        </h1>

        <p class="description">

            Imagine Works creates modern digital experiences,
            creative designs and innovative solutions that help
            brands stand out in the digital world.
        </p>

        <div class="hero-buttons">
            <a href="#portfolio" class="primary-btn">
                View Our Work →
            </a>

            <a href="#services" class="secondary-btn">
                Explore Services
            </a>
        </div>
    </div>

    <div class="hero-image">
        <div class="image-box">
            <div class="image-placeholder">
                IMAGINE<br>
                WORKS
            </div>
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
        <!--SERVICE 01-->
        <div class="service-card">
            <span class="service-number">
                01
            </span>

            <h3>
                Software Company
            </h3>

            <p>
                Software development and digital solutions
                designed to meet different business needs.
            </p>

            <a href="services/software.php"
               class="service-btn">

                Explore Services →
            </a>
        </div>

        <!--SERVICE 02-->
        <div class="service-card">
            <span class="service-number">
                02
            </span>

            <h3>
                Web Hosting Company
            </h3>

            <p>
                Reliable web hosting and online solutions
                for websites and businesses.
            </p>

            <a href="services/hosting.php"
               class="service-btn">

                Explore Services →
            </a>
        </div>

        <!-- SERVICE 03 -->
        <div class="service-card">
            <span class="service-number">
                03
            </span>

            <h3>
                Internet Marketing Service
            </h3>

            <p>
                Digital marketing solutions that help
                businesses improve their online presence.
            </p>

            <a href="services/internet.php"
               class="service-btn">

                Explore Services →
            </a>
        </div>

        <!--SERVICE 04-->
        <div class="service-card">
            <span class="service-number">
                04
            </span>

            <h3>
                Computer Support & Services
            </h3>

            <p>
                Technical support and computer solutions
                for individuals and businesses.
            </p>

            <a href="services/computerservices.php"
               class="service-btn">

                Explore Services →
            </a>
        </div>
    </div>
</section>


<!-- PORTFOLIO-->
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
        <!-- PROJECT 01 -->
        <div class="project-card">
            <div class="project-image">
                PROJECT 01
            </div>

            <h3>
                Creative Business Website
            </h3>

            <p>
                Web Development
            </p>
        </div>


        <!-- PROJECT 02 -->
        <div class="project-card">
            <div class="project-image">
                PROJECT 02
            </div>

            <h3>
                Modern Digital Experience
            </h3>

            <p>
                UI/UX Design
            </p>
        </div>


        <!-- PROJECT 03 -->
        <div class="project-card">
            <div class="project-image">
                PROJECT 03
            </div>

            <h3>
                Brand Identity Project
            </h3>

            <p>
                Branding
            </p>
        </div>
    </div>


    <div class="portfolio-button">
        <a href="portfolio.php"
           class="secondary-btn">

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

    <a href="#contact"
       class="primary-btn">

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

    <form class="contact-form"
          action="contact.php"
          method="POST">

        <input
            type="text"
            name="name"
            placeholder="Your Name"
            required>
        

        <input
            type="email"
            name="email"
            placeholder="Your Email"
            required>
       

        <input
            type="text"
            name="subject"
            placeholder="Subject"
            required>
       

        <textarea
            name="message"
            placeholder="Tell us about your project..."
            required>
        
    </textarea>


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

        <a href="#portfolio.php">
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