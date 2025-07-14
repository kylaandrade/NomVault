<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
    if (!$check) {
        die("Prepare failed: " . $conn->error);
    }

    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "Email already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sss", $name, $email, $pass);
        $stmt->execute();
        header("Location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - NomVault</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
  <img src="assets/logo.png" class="logo" alt="NomVault Logo">
  <nav>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
  </nav>
</header>
<div class="container">
    <form method="post" class="auth-form">
        <h2>Create Account</h2>
        <p class="subtitle">Start your recipe journey</p>
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </form>
</div>
</body>
</html>