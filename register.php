<?php
<<<<<<< HEAD
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';

=======
include 'db.php';
>>>>>>> 2f94898824effd64bb9c74b1007bf2aff003fda6
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

<<<<<<< HEAD
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $check = $conn->prepare("SELECT id FROM users WHERE email=?");

    if (!$check) {
        die("Prepare failed: " . $conn->error);
    }

=======
    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
>>>>>>> 2f94898824effd64bb9c74b1007bf2aff003fda6
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "Email already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
<<<<<<< HEAD

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

=======
        $stmt->bind_param("sss", $name, $email, $pass);
        $stmt->execute();
        header("Location: login.php");
    }
}
?>
>>>>>>> 2f94898824effd64bb9c74b1007bf2aff003fda6
<link rel="stylesheet" href="css/style.css">
<header><img src="assets/logo.png" class="logo"><nav><a href="login.php">Login</a></nav></header>
<div class="container">
    <form method="post">
        <h2>Register</h2>
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </form>
<<<<<<< HEAD
</div>
=======
</div>
>>>>>>> 2f94898824effd64bb9c74b1007bf2aff003fda6
