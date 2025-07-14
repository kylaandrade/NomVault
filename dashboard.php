<?php include 'session.php'; include 'db.php'; ?>
<link rel="stylesheet" href="css/style.css">
<header>
    <img src="assets/logo.png" class="logo">
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="add_recipe.php">Add Recipe</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>
<div class="container">
    <h1>Your Recipes</h1>
    <div class="cards">
        <?php
        $stmt = $conn->prepare("SELECT * FROM recipes WHERE user_id=?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()):
        ?>
        <div class="card">
            <img src="uploads/<?= htmlspecialchars($row['photo']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars(substr($row['ingredients'], 0, 150))) ?>...</p>
            <div class="actions">
                <a href="edit_recipe.php?id=<?= $row['id'] ?>">Edit</a>
                <a href="delete_recipe.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this recipe?')">Delete</a>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>