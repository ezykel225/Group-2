<?php
session_start();
include 'db.php';

// Ensure the user is logged in
if (!isset($_SESSION['student']['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student']['student_id']; // Use the session to get the student ID

$time_slots = [
    "07:00", "08:00", "09:00", "10:00", "11:00",
    "12:00", "13:00", "14:00", "15:00", "16:00",
    "17:00", "18:00", "19:00", "20:00"
];

$days = ['Friday', 'Saturday', 'Sunday'];

// Fetch schedule entries
$schedule_data = [];
$sql = "SELECT * FROM schedule WHERE student_id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $start = strtotime($row['time_start']);
    $end = strtotime($row['time_end']);
    $rowspan = ($end - $start) / 3600; // number of hours
    $hour = date("H:00", $start);
    $key = $row['day'] . '_' . $hour;

    // Generate CSS class from subject name
    $class = strtolower(str_replace([' ', '-', '2', '4'], '', $row['subject_name']));

    $schedule_data[$key] = [
        'subject' => $row['subject_name'],
        'room' => $row['room'],
        'rowspan' => $rowspan,
        'class' => $class
    ];

    // Fill blocked hours so we don't duplicate cell
    for ($i = 1; $i < $rowspan; $i++) {
        $blocked_time = date("H:00", strtotime("+$i hour", $start));
        $block_key = $row['day'] . '_' . $blocked_time;
        $schedule_data[$block_key] = 'skip';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Student Schedule</title>
    <link rel="stylesheet" href="header.css"/>
    <link rel="stylesheet" href="schedule.css"/>
    <link rel="stylesheet" href="feedback.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap" rel="stylesheet" />
</head>
<body>
    <?php $showBackButton = true; include 'header.php'; ?>

    <div class="container">
        <h1>Class Schedule</h1>
        <table class="schedule-table">
            <thead>
                <tr>
                    <th>Time</th>
                    <?php foreach ($days as $day): ?>
                        <th><?= htmlspecialchars($day) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($time_slots as $time): ?>
                    <tr>
                        <td><?= $time ?></td>
                        <?php foreach ($days as $day): ?>
                            <?php
                                $key = $day . '_' . $time;
                                $entry = $schedule_data[$key] ?? null;

                                if ($entry === 'skip') {
                                    continue; // already shown via rowspan
                                } elseif (is_array($entry)) {
                                    echo "<td class='{$entry['class']}' rowspan='{$entry['rowspan']}'>{$entry['subject']} ({$entry['room']})</td>";
                                } else {
                                    echo "<td></td>";
                                }
                            ?>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php include 'feedback.php'; ?>
</body>
</html>