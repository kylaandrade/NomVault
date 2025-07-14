<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - NomVault</title>
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
        <h2>Welcome Back</h2>
        <p class="subtitle">Login to your Recipe Journal</p>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </form>
</div>
</body>
</html>