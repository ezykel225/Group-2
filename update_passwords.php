<?php
include("db.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$students = [
    ['student_id' => '2023-24511183', 'plain_password' => 'CarlV-2000'],
    ['student_id' => '2023-24511166', 'plain_password' => 'PatriciaL-2004'],
    ['student_id' => '2023-24511159', 'plain_password' => 'JoelG-2004'],
    ['student_id' => '2023-24511154', 'plain_password' => 'EzequelB-2005'],
    ['student_id' => '2023-24511150', 'plain_password' => 'GleaA-2004'],
    ['student_id' => '2023-24511169', 'plain_password' => 'JamesA-2000'],
    ['student_id' => '2023-24511178', 'plain_password' => 'AnthonyM-2005'],
    ['student_id' => '2023-24511190', 'plain_password' => 'StewardH-2004'],
    ['student_id' => '2023-24511194', 'plain_password' => 'FrancisS-2004'],
    ['student_id' => '2023-24511120', 'plain_password' => 'RheaH-2004']
];

$stmt = $conn->prepare("UPDATE students SET password = ? WHERE student_id = ?");

foreach ($students as $student) {
    $hashed_password = password_hash($student['plain_password'], PASSWORD_DEFAULT);
    $stmt->bind_param("ss", $hashed_password, $student['student_id']);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        echo "Password updated for student ID: " . $student['student_id'] . "<br>";
    } else {
        echo "Failed to update password for student ID: " . $student['student_id'] . "<br>";
    }
}

$stmt->close();
$conn->close();
?>