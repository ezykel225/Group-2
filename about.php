<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | Student Information System</title>
    <link rel="stylesheet" href="about.css">
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
                <li><a href="index.php" class="nav-link">Home</a></li>
                <li class="active"><a href="about.php" class="nav-link">About<div class="underline"></div></a></li>
                <li><a href="login.php" class="nav-link">Login</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="about-hero">
            <h2>About the Student Information System</h2>
            <p>Welcome to our comprehensive Student Information System (SIS), designed to streamline all academic and administrative processes for students, faculty, and staff.</p>
        </div>
        <section class="info-card-section">
            <div class="info-card">
                <h3>Features</h3>
                <ul>
                    <li>Student Registration & Admissions</li>
                    <li>Personal Profile Management</li>
                    <li>Class Scheduling & Enrollments</li>
                    <li>Grade Tracking & Transcript Generation</li>
                    <li>Attendance Monitoring</li>
                    <li>Tuition & Fees Management</li>
                    <li>Announcements & Notifications</li>
                    <li>Support for Faculty and Admin Users</li>
                </ul>
            </div>
            <div class="info-card">
                <h3>Benefits</h3>
                <ul>
                    <li>Centralized, secure student records</li>
                    <li>Easy access to grades, schedules, and requirements</li>
                    <li>Improved communication and notifications</li>
                    <li>Paperless and automated transactions</li>
                    <li>Data analytics and reporting for administrators</li>
                </ul>
            </div>
        </section>
        <section class="faq-section">
            <h3>Frequently Asked Questions</h3>
            <div class="faq">
                <h4>How do I update my personal profile?</h4>
                <p>After logging in, go to the 'Profile' section in your dashboard and click 'Edit' to update your personal and contact information.</p>
            </div>
            <div class="faq">
                <h4>How can I check my grades?</h4>
                <p>Your current and past grades are available in the 'Grades' section once you log in to your SIS account.</p>
            </div>
            <div class="faq">
                <h4>Who do I contact for support?</h4>
                <p>For technical issues or questions, contact the Registrar's office or use the 'Help & Support' link in your user dashboard.</p>
            </div>
        </section>
    </main>

    <?php include 'feedback.php'; ?>

</body>
</html>
