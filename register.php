<?php
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 8d212050fd02e734fd35955b12dbe2a6da7de016
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';

<<<<<<< HEAD
=======
=======
include 'db.php';
>>>>>>> 2f94898824effd64bb9c74b1007bf2aff003fda6
>>>>>>> 8d212050fd02e734fd35955b12dbe2a6da7de016
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

<<<<<<< HEAD
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
<<<<<<< HEAD
=======

>>>>>>> 8d212050fd02e734fd35955b12dbe2a6da7de016
    if (!$check) {
        die("Prepare failed: " . $conn->error);
    }

<<<<<<< HEAD
=======
=======
    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
>>>>>>> 2f94898824effd64bb9c74b1007bf2aff003fda6
>>>>>>> 8d212050fd02e734fd35955b12dbe2a6da7de016
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "Email already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
<<<<<<< HEAD
=======
<<<<<<< HEAD

>>>>>>> 8d212050fd02e734fd35955b12dbe2a6da7de016
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

<<<<<<< HEAD
=======
        $stmt->bind_param("sss", $name, $email, $pass);
        $stmt->execute();
        header("Location: login.php");
        exit();
    }
}
?>

=======
>>>>>>> 8d212050fd02e734fd35955b12dbe2a6da7de016
        $stmt->bind_param("sss", $name, $email, $pass);
        $stmt->execute();
        header("Location: login.php");
        exit();
    }
}
?>
<<<<<<< HEAD
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
=======
>>>>>>> 2f94898824effd64bb9c74b1007bf2aff003fda6
<link rel="stylesheet" href="css/style.css">
<header><img src="assets/logo.png" class="logo"><nav><a href="login.php">Login</a></nav></header>
>>>>>>> 8d212050fd02e734fd35955b12dbe2a6da7de016
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
<<<<<<< HEAD
</div>
</body>
</html>
=======
<<<<<<< HEAD
</div>
=======
</div>
>>>>>>> 2f94898824effd64bb9c74b1007bf2aff003fda6
>>>>>>> 8d212050fd02e734fd35955b12dbe2a6da7de016
