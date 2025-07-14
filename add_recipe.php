<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];
    $user_id = $_SESSION['user_id'];

    $photo = null;
    if ($_FILES['photo']['name']) {
        $photo = uniqid() . "_" . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/$photo");
    }

    $stmt = $conn->prepare("INSERT INTO recipes (user_id, title, ingredients, steps, photo) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $title, $ingredients, $steps, $photo);
    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Recipe - NomVault</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <img src="assets/logo.png" class="logo" alt="NomVault Logo">
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="add_recipe.php">Add Recipe</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>
<div class="container">
    <form method="post" enctype="multipart/form-data" class="auth-form">
        <h2>Add New Recipe</h2>
        <input type="text" name="title" placeholder="Recipe Title" required>
        <textarea name="ingredients" placeholder="Ingredients (one per line)" rows="5" required></textarea>
        <textarea name="steps" placeholder="Cooking Steps" rows="5" required></textarea>
        <input type="file" name="photo" accept="image/*">
        <button type="submit">Save Recipe</button>
    </form>
</div>
</body>
</html>