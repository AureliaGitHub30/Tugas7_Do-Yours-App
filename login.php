<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    

    session_start();
    $conn = new mysqli("localhost", "root", "", "do_yours", 3307);
    

    if (isset($_SESSION['user_id'])) {
        header("Location: http://localhost/tugas7_pemweb/app.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error = "Invalid email format!";
        } else {
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows >0){
                $user = $result->fetch_assoc();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $email;
                header("Location: app.php");
                exit();
            } else {
                $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
                $stmt->bind_param("ss", $email, $password);
                $stmt->execute();
    
                // Ambil ID user baru
                $new_user_id = $stmt->insert_id;
                $_SESSION['user_id'] = $new_user_id;
                $_SESSION['email'] = $email;
                header("Location: app.php");
                exit();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Do Yours App</title>
    <link rel="stylesheet" href="style.css"> <!-- dipanggil disini -->
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <button class="login-btn" type="submit">
                Login
            </button>
        </form>
    </div>
</body>
</html>
