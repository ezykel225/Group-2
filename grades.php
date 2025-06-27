<?php
session_start();
include 'db.php';

// Ensure the user is logged in
if (!isset($_SESSION['student']['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student']['student_id']; // Use the session to get the student ID

$query_1st = "SELECT * FROM grades WHERE student_id = '$student_id' AND semester = '1st'";
$query_2nd = "SELECT * FROM grades WHERE student_id = '$student_id' AND semester = '2nd'";

$result_1st = mysqli_query($conn, $query_1st);
$result_2nd = mysqli_query($conn, $query_2nd);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grades</title>
    <link rel="stylesheet" href="header.css" />
    <link rel="stylesheet" href="grades.css" />
    <link rel="stylesheet" href="feedback.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap" rel="stylesheet" />
</head>
<body>
    <?php
    $showBackButton = true;
    include 'header.php';
    ?>

    <div class="container">
        <h1>Student Grades</h1>

        <div class="grade-columns">
            <div class="grade-table">
                <h2>First Semester</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Prelim</th>
                            <th>Midterm</th>
                            <th>Finals</th>
                            <th>Average</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result_1st)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['subject_name']) ?></td>
                            <td><?= htmlspecialchars($row['prelim']) ?></td>
                            <td><?= htmlspecialchars($row['midterm']) ?></td>
                            <td><?= htmlspecialchars($row['finals']) ?></td>
                            <td><?= htmlspecialchars(number_format($row['average'], 2)) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="grade-table">
                <h2>Second Semester</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Prelim</th>
                            <th>Midterm</th>
                            <th>Finals</th>
                            <th>Average</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result_2nd)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['subject_name']) ?></td>
                            <td><?= htmlspecialchars($row['prelim']) ?></td>
                            <td><?= htmlspecialchars($row['midterm']) ?></td>
                            <td><?= htmlspecialchars($row['finals']) ?></td>
                            <td><?= htmlspecialchars(number_format($row['average'], 2)) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php include 'feedback.php'; ?>

</body>
</html>