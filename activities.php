<?php
session_start();
include 'db.php';

// Check if student is logged in
if (!isset($_SESSION['student']['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student']['student_id'];

// Fetch activities for logged-in student
$sql = "SELECT subject, activity, status, due_date FROM activities WHERE student_id = ? ORDER BY due_date ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Activities | Student Information System</title>
    <link rel="stylesheet" href="activities.css" />
    <link rel="stylesheet" href="header.css" />
    <link rel="stylesheet" href="feedback.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap" rel="stylesheet" />
    <style>
        /* Basic styling for status */
        .status-completed {
            color: green;
            font-weight: bold;
        }
        .status-missed {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php
    $showBackButton = true;
    include 'header.php';
    ?>
<main>
    <h2 class="page-title">Activities</h2>

    <section class="activities-list">
        <h3>Subject Activities</h3>

        <table class="activities-table">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Activity</th>
                    <th>Status</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['subject']) ?></td>
                            <td><?= htmlspecialchars($row['activity']) ?></td>
                            <td class="status-<?= strtolower($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></td>
                            <td><?= date("F j, Y", strtotime($row['due_date'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4" style="text-align:center;">No activities found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<?php include 'feedback.php'; ?>

</body>
</html>
