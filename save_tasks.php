<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);

$conn = new mysqli("localhost", "root", "", "do_yours");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}
$conn->query("DELETE FROM do_yours_app WHERE user_id='$user_id'");

$stmt = $conn->prepare("INSERT INTO do_yours_app (user_id, task, completed) VALUES (?, ?, ?)");

foreach ($data as $task) {
    $text = $task['text'];
    $completed = $task['completed'] ? 1 : 0;
    $stmt->bind_param("isi", $user_id, $text, $completed);
    $stmt->execute();
}

echo json_encode(["status" => "ok"]);
?>