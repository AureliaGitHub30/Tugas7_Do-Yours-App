<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/tugas7_pemweb/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Do Yours App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div style="text-align: right; width: 100%; padding: 10px;">
            <a href="logout.php" style="color: white; background: #5b7edb; padding: 10px 20px; border-radius: 10px; text-decoration: none;">
                Logout
            </a>
        </div>

        <h2>Welcome, <?= $_SESSION['user_id']; ?>!</h2>
        <div class="stats-container">
            <div class="details">
                <h1>Do Yours</h1>
                <p>Keep it up!</p>
                <div id="progressBar"><div id="progress"></div></div>
            </div>
            <div class="stats-numbers">
                <p id="numbers">0 / 0</p>
            </div>
        </div>

        <form action="">
            <input type="text" id="taskInput" placeholder="Write you must to do!"/>
            <button id="newTask" type="submit">+</button>
        </form>
        <ul id="task-list"></ul>
    </div>

    <script src="app.js"></script>
</body>
</html>
