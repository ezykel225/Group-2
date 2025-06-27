<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['student']['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student']['student_id']; // Use session to get the student_id

// Fetch student data
$query = "SELECT * FROM students WHERE student_id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

// Handle case if student not found
if (!$student) {
    echo "<h2 style='text-align:center; margin-top: 50px;'>Student not found.</h2>";
    exit();
}

// Set a default photo if profile_photo is empty
$profile_photo = !empty($student['profile_photo']) ? $student['profile_photo'] : 'assets/student-photo.jpg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Personal Information | Student Info System</title>
  <link rel="stylesheet" href="personal-info.css" />
  <link rel="stylesheet" href="header.css">
  <link rel="stylesheet" href="feedback.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap" rel="stylesheet" />
</head>
<body>
  <?php
    $showBackButton = true;
    include 'header.php';
  ?>

  <main>
    <h2 class="page-title">Personal Information</h2>
    <div class="personal-layout">
      <!-- Left Feature -->
      <div class="side-box">
        <h3>📘 Study Tip</h3>
        <p>"Manage your time well. Consistency beats cramming every time."</p>

        <h3>📌 System Note</h3>
        <p>Keep your contact and guardian info up to date to avoid delays in records.</p>
      </div>

      <!-- Personal Info Card -->
      <div class="info-card">
        <img src="<?= htmlspecialchars($profile_photo) ?>" alt="Student Photo" class="profile-img" />

        <div class="info-row"><label>Full Name:</label><p><?= htmlspecialchars($student['full_name']) ?></p></div>
        <div class="info-row"><label>Student ID:</label><p><?= htmlspecialchars($student['student_id']) ?></p></div>
        <div class="info-row"><label>Course:</label><p><?= htmlspecialchars($student['course']) ?></p></div>
        <div class="info-row"><label>Year Level:</label><p><?= htmlspecialchars($student['year_level']) ?></p></div>
        <div class="info-row"><label>School Email:</label><p><?= htmlspecialchars($student['school_email']) ?></p></div>
        <div class="info-row"><label>Birthday:</label><p><?= date("F j, Y", strtotime($student['birthday'])) ?></p></div>
        <div class="info-row"><label>Gender:</label><p><?= htmlspecialchars($student['gender']) ?></p></div>
        <div class="info-row"><label>Nationality:</label><p><?= htmlspecialchars($student['nationality']) ?></p></div>
        <div class="info-row"><label>Contact Number:</label><p><?= htmlspecialchars($student['contact_number']) ?></p></div>
        <div class="info-row"><label>Guardian Name:</label><p><?= htmlspecialchars($student['guardian_name']) ?></p></div>
        <div class="info-row"><label>Address:</label><p><?= htmlspecialchars($student['address']) ?></p></div>
      </div>

      <!-- Right Feature -->
      <div class="side-box">
        <h3>🎯 Career Reminder</h3>
        <p>Start building your resume now! Join clubs and get internship-ready.</p>

        <h3>✨ Quote of the Day</h3>
        <p>"Success is the sum of small efforts repeated day in and day out."</p>
      </div>
    </div>
  </main>

  <?php include 'feedback.php'; ?>

</body>
</html>