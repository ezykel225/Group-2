<?php
session_start();
include 'db.php';

// Check if student is logged in
if (!isset($_SESSION['student']['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student']['student_id']; // Use session to get the student ID

$query = "SELECT student_id, student_name, subject_name, attendance_date, status 
          FROM attendance 
          WHERE student_id = ? 
          ORDER BY attendance_date DESC";

$stmt = mysqli_prepare($conn, $query);
if ($stmt === false) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $student_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Attendance</title>
    <link rel="stylesheet" href="attendance.css" />
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="feedback.css">
</head>
<body>
    <?php
    $showBackButton = true;
    include 'header.php';
    ?>
    <div class="container">
        <h1>Attendance Records</h1>
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['student_id']) ?></td>
                        <td><?= htmlspecialchars($row['student_name']) ?></td>
                        <td><?= htmlspecialchars($row['subject_name']) ?></td>
                        <td><?= htmlspecialchars(date("M d, Y", strtotime($row['attendance_date']))) ?></td>
                        <td class="<?= $row['status'] === 'Present' ? 'present' : 'absent' ?>">
                            <?= htmlspecialchars($row['status']) ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php include 'feedback.php'; ?>

</body>
</html>