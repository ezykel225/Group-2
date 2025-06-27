<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feedback_text']) && isset($_SESSION['student']['student_id'])) {
    $feedback_text = trim($_POST['feedback_text']);
    $user_id = $_SESSION['student']['student_id'];

    $stmt = $conn->prepare("INSERT INTO feedback (user_id, feedback_text) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $feedback_text);

    if ($stmt->execute()) {
        $_SESSION['feedback_success'] = true;
    } else {
        $_SESSION['feedback_error'] = true;
    }

    $stmt->close();
    $conn->close();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>