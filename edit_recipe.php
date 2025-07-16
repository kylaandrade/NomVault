<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$recipe_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM recipes WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $recipe_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$recipe = $result->fetch_assoc();

if (!$recipe) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];

    $photo = $recipe['photo'];
    if (!empty($_FILES['photo']['name'])) {
        $photo = uniqid() . "_" . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/$photo");
    }

    $stmt = $conn->prepare("UPDATE recipes SET title = ?, ingredients = ?, steps = ?, photo = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssssii", $title, $ingredients, $steps, $photo, $recipe_id, $user_id);
    $stmt->execute();

    header("Location: dashboard.php?success=edit");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Recipe - NomVault</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <img src="assets/logo.png" class="logo" alt="NomVault Logo">
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="add_recipe.php">Add Recipe</a>
        <a href="logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
    </nav>
</header>
<div class="container">
    <form method="post" enctype="multipart/form-data" class="auth-form">
        <h2>Edit Recipe</h2>
        <input type="text" name="title" value="<?= $recipe['title'] ?>" placeholder="Recipe Title" required>
        <textarea name="ingredients" placeholder="Ingredients (one per line)" rows="5" required><?= $recipe['ingredients'] ?></textarea>
        <textarea name="steps" placeholder="Cooking Steps" rows="5" required><?= $recipe['steps'] ?></textarea>

        <?php if ($recipe['photo']): ?>
            <img src="uploads/<?= $recipe['photo'] ?>" alt="Current Photo" style="max-width: 100%; margin-bottom: 10px; border-radius: 8px;">
        <?php endif; ?>

        <input type="file" name="photo" accept="image/*">
        <button type="submit">Update Recipe</button>
    </form>
</div>
</body>
</html>