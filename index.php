<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information System</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="feedback.css"> 
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="logo-section">
            <img src="assets/Logo.png" alt="Asian College Logo" class="logo">
            <div>
                <h1>
                    <span>Student</span><br>
                    <span>Information</span><br>
                    <span>System</span>
                </h1>
            </div>
        </div>
        <nav>
            <ul>
                <li class="active"><a href="index.php" class="nav-link">Home<div class="underline"></div></a></li>
                <li><a href="about.php" class="nav-link">About</a></li>
                <li><a href="login.php" class="nav-link">Login</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-text">
                <h2>
                    Developing <br>
                    <span>LEADERS in</span><br>
                    <span>IT and MANAGEMENT</span>
                </h2>
            </div>
            <div class="hero-image">
                <img src="assets/ac-dumaguete-campus.jpg" alt="Building Photo">
            </div>
        </section>

        <section class="bottom-section">
            <div class="about">
                <h3>What is ACSAT?</h3>
                <p>
                    Asian College of Science and Technology (Asian College) is a CHED and TESDA-accredited
                    tertiary educational institution dedicated to the success of its graduates in their
                    chosen field of study. With campus in Dumaguete, Asian College has produced thousands
                    of high-quality graduates with globally relevant skills and knowledge for 48 years.
                </p>
            </div>
            <div class="features">
                <div class="feature">
                    <div class="icon"><span>&#127757;</span></div>
                    <div>
                        <h4>Experience</h4>
                        <p>"Years of learning, growth, and real-world skills that empower futures."</p>
                    </div>
                </div>
                <div class="feature">
                    <div class="icon"><span>&#128203;</span></div>
                    <div>
                        <h4>Excellence</h4>
                        <p>"Driven by passion, guided by quality, achieving beyond all limits."</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'feedback.php'; ?> <!-- Include feedback module -->

</body>
</html>