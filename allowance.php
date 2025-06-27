<?php
session_start();
include 'db.php';

// Check if student is logged in
if (!isset($_SESSION['student']['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student']['student_id'];

// Query allowance data for this student
$sql = "SELECT year_level, semester, payment1, payment2, payment3, total FROM allowances WHERE student_id = ? ORDER BY year_level, semester";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$allowances = [];
while ($row = $result->fetch_assoc()) {
    $allowances[] = $row;
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Instructional Allowance | Student Information System</title>
    <link rel="stylesheet" href="allowance.css" />
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
        <h2 class="page-title">Instructional Allowance</h2>
        <p class="info-text">You receive ₱14,500 per semester divided into 3 payments.</p>

        <?php if (count($allowances) > 0): ?>
            <table class="allowance-table">
                <thead>
                    <tr>
                        <th>Year Level</th>
                        <th>Semester</th>
                        <th>Payment 1</th>
                        <th>Payment 2</th>
                        <th>Payment 3</th>
                        <th>Total Received</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // To group rows by year level and avoid repeating rowspan manually, 
                    // we can handle it in PHP:
                    $currentYear = "";
                    $yearCount = 0;
                    $yearRows = [];

                    // First count how many rows per year level
                    foreach ($allowances as $row) {
                        $yearRows[$row['year_level']] = ($yearRows[$row['year_level']] ?? 0) + 1;
                    }

                    foreach ($allowances as $index => $row):
                        $showYearCell = false;
                        if ($row['year_level'] !== $currentYear) {
                            $currentYear = $row['year_level'];
                            $showYearCell = true;
                            $yearCount = $yearRows[$currentYear];
                        }
                    ?>
                    <tr>
                        <?php if ($showYearCell): ?>
                            <td rowspan="<?= $yearCount ?>"><?= htmlspecialchars($row['year_level']) ?></td>
                        <?php endif; ?>
                        <td><?= htmlspecialchars($row['semester']) ?></td>
                        <td>₱<?= number_format($row['payment1'], 2) ?></td>
                        <td>₱<?= number_format($row['payment2'], 2) ?></td>
                        <td>₱<?= number_format($row['payment3'], 2) ?></td>
                        <td>₱<?= number_format($row['total'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No allowance data found for your account.</p>
        <?php endif; ?>
    </main>

<?php include 'feedback.php'; ?>

</body>
</html>
