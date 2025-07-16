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

$count_stmt = $conn->prepare("SELECT COUNT(*) as total FROM recipes WHERE user_id=?");
$count_stmt->bind_param("i", $user_id);
$count_stmt->execute();
$count_result = $count_stmt->get_result()->fetch_assoc();
$total_recipes = $count_result['total'];

$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $stmt = $conn->prepare("SELECT * FROM recipes WHERE user_id=? AND (title LIKE CONCAT('%', ?, '%') OR ingredients LIKE CONCAT('%', ?, '%')) ORDER BY id DESC");
    $stmt->bind_param("iss", $user_id, $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - NomVault</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/logout_confirm.js" defer></script>
</head>
<body>
<header>
    <img src="assets/logo.png" class="logo" alt="NomVault Logo">
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="add_recipe.php">Add Recipe</a>
        <a href="logout.php" onclick="confirmLogout(event)">Logout</a>
    </nav>
</header>

<div class="container">
    <h2 class="dashboard-heading">Your Saved Recipes</h2>
    <p class="dashboard-subtext">Welcome to your personal recipe vault! Save, organize, and share your favorite recipes all in one place.</p>

    <?php if (isset($_GET['success'])): ?>
        <?php
            $message = "";
            $alertClass = "";
            if ($_GET['success'] === 'add') {
                $message = "Recipe added successfully!";
                $alertClass = "alert-success";
            } elseif ($_GET['success'] === 'edit') {
                $message = "Recipe updated successfully!";
                $alertClass = "alert-success";
            } elseif ($_GET['success'] === 'delete') {
                $message = "Recipe deleted successfully!";
                $alertClass = "alert-danger";
            }
        ?>
        <div class="alert <?= $alertClass ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <div class="info-cards">
        <div class="info-card">
            <h3><?= $total_recipes ?></h3>
            <p>Total Recipes</p>
        </div>
    </div>

    <form method="GET" class="search-form">
        <input type="text" name="search" placeholder="Search recipes..." value="<?= $search ?>">
        <button type="submit">Search</button>
    </form>

    <div class="cards">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="recipe-card">
                    <?php if ($row['photo']): ?>
                        <img src="uploads/<?= $row['photo'] ?>" alt="<?= $row['title'] ?>">
                    <?php endif; ?>
                    <h3><?= $row['title'] ?></h3>
                    <p><strong>Ingredients:</strong> <?= $row['ingredients'] ?></p>
                    <hr class="divider">
                    <p><strong>Steps:</strong> <?= $row['steps'] ?></p>
                    <div class="actions">
                        <a href="edit_recipe.php?id=<?= $row['id'] ?>" class="btn edit">Edit</a>
                        <a href="delete_recipe.php?id=<?= $row['id'] ?>" class="btn delete" onclick="return confirm('Delete this recipe?')">Delete</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-results">No recipes found for your search.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>