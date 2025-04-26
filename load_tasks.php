<?php
session_start();
if (!isset($_SESSION['user_id'])) exit;

$email = $_SESSION['user_id'];
$conn = new mysqli("localhost", "root", "", "do_yours");

$result = $conn->query("SELECT task, completed FROM do_yours_app WHERE user_id='$email'");
$tasks = [];

while ($row = $result->fetch_assoc()) {
    $tasks[] = [
        "text" => $row['task'],
        "completed" => $row['completed'] == 1
    ];
}

echo json_encode($tasks);
