<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM recipes WHERE user_id=? ORDER BY id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - NomVault</title>
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
<div class="container cards">
    <h2>Your Saved Recipes</h2>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="recipe-card">
            <?php if ($row['photo']): ?>
                <img src="uploads/<?= $row['photo'] ?>" alt="<?= htmlspecialchars($row['title']) ?>">
            <?php endif; ?>
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <p><strong>Ingredients:</strong> <?= nl2br(htmlspecialchars($row['ingredients'])) ?></p>
            <p><strong>Steps:</strong> <?= nl2br(htmlspecialchars($row['steps'])) ?></p>
            <div class="actions">
                <a href="edit_recipe.php?id=<?= $row['id'] ?>" class="btn edit">Edit</a>
                <a href="delete_recipe.php?id=<?= $row['id'] ?>" class="btn delete" onclick="return confirm('Are you sure you want to delete this recipe?')">Delete</a>
            </div>
        </div>
    <?php endwhile; ?>
</div>
</body>
</html>