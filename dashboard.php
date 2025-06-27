<?php
session_start();

if (!isset($_SESSION['student']['student_id'])) {
    header("Location: login.php");
    exit();
}

require 'db.php';

$student_id = $_SESSION['student']['student_id'];
$query = "SELECT * FROM students WHERE student_id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows === 0) {
    echo "<h2>Student not found</h2>";
    exit();
}

$student = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard | Student Information System</title>
    <link rel="stylesheet" href="header.css" />
    <link rel="stylesheet" href="dashboard.css" />
    <link rel="stylesheet" href="feedback.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap" rel="stylesheet" />
</head>
<body>
    <?php
    $showBackButton = false;
    include 'header.php';
    ?>

    <main>
        <h2 class="dashboard-title">Dashboard</h2>
        <div class="dashboard-flex">
            <div class="profile-column">
                <div class="profile-card">
                    <img src="<?php echo htmlspecialchars($student['profile_photo']); ?>" alt="Student Photo" class="student-photo" />
                    <div class="profile-info">
                        <h2><?php echo htmlspecialchars($student['full_name']); ?></h2>
                        <p>ID: <?php echo htmlspecialchars($student['student_id']); ?></p>
                        <p>Course: <?php echo htmlspecialchars($student['course']); ?></p>
                        <p>Year Level: <?php echo htmlspecialchars($student['year_level']); ?></p>
                        <p>School Email: <?php echo htmlspecialchars($student['school_email']); ?></p>
                    </div>
                </div>

                <div class="statistics-cards">
                    <div class="stat-card">
                        <div class="stat-title">Subjects</div>
                        <div class="stat-value">8</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-title">Standing</div>
                        <div class="stat-value stat-good">Good</div>
                    </div>
                </div>
            </div>

            <div class="features-column">
                <div class="quick-links-grid">
                    <a class="quick-link" href="personal-info.php">
                        <span class="ql-icon">&#128218;</span>
                        <div>
                            <div class="ql-title">Personal Information</div>
                            <div class="ql-desc">Review your student details at a glance</div>
                        </div>
                    </a>
                    <a class="quick-link" href="activities.php">
                        <span class="ql-icon">&#9997;</span>
                        <div>
                            <div class="ql-title">Activities</div>
                            <div class="ql-desc">Check your subject activities</div>
                        </div>
                    </a>
                    <a class="quick-link" href="allowance.php">
                        <span class="ql-icon">&#128179;</span>
                        <div>
                            <div class="ql-title">Instructional Allowance</div>
                            <div class="ql-desc">Track your allowance payments</div>
                        </div>
                    </a>
                    <a class="quick-link" href="grades.php">
                        <span class="ql-icon">&#127942;</span>
                        <div>
                            <div class="ql-title">Grades</div>
                            <div class="ql-desc">View your academic performance</div>
                        </div>
                    </a>
                    <a class="quick-link" href="schedule.php">
                        <span class="ql-icon">&#128197;</span>
                        <div>
                            <div class="ql-title">Schedule</div>
                            <div class="ql-desc">See your class timetable</div>
                        </div>
                    </a>
                    <a class="quick-link" href="attendance.php">
                        <span class="ql-icon">&#128101;</span>
                        <div>
                            <div class="ql-title">Attendance</div>
                            <div class="ql-desc">Monitor your attendance record</div>
                        </div>
                    </a>
                </div>

                <div class="announcements-card">
                    <h3>Latest Announcements</h3>
                    <p>No new announcements.</p>
                </div>
            </div>
        </div>
    </main>

    <?php include 'feedback.php'; ?>

</body>
</html>