<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM admin1 WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user'] = $user['user'];
            $_SESSION['email'] = $user['email'];

            if ($user['email'] === 'admin@gmail.com') {
                $_SESSION['role'] = 'admin';
                header("Location: Admin_dashboard.php");
                exit();
            } else {
                $_SESSION['role'] = 'user';
                header("Location: camera.php");
                exit();
            }
        } else {
            $error_message = "Invalid email or password.";
        }
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="CSS/d1login.css">
    <link rel="stylesheet" href="CSS/fonts.css">
</head>
<body>
    <div class="login-container">
        <form action="login.php" method="post">
            <h2>Login</h2>
            <?php if (isset($error_message)) { echo "<p style='color: red;'>$error_message</p>"; } ?>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </form>
    </div>
</body>
</html>
