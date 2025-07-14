<?php
include 'session.php'; include 'db.php';
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM recipes WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $id, $_SESSION['user_id']);
$stmt->execute();
$res = $stmt->get_result();
$recipe = $res->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];
    $stmt = $conn->prepare("UPDATE recipes SET title=?, ingredients=?, steps=? WHERE id=? AND user_id=?");
    $stmt->bind_param("sssii", $title, $ingredients, $steps, $id, $_SESSION['user_id']);
    $stmt->execute();
    header("Location: dashboard.php");
}
?>
<link rel="stylesheet" href="css/style.css">
<header><img src="assets/logo.png" class="logo"><nav><a href="dashboard.php">Dashboard</a></nav></header>
<div class="container">
    <form method="post">
        <h2>Edit Recipe</h2>
        <input type="text" name="title" value="<?= htmlspecialchars($recipe['title']) ?>" required>
        <textarea name="ingredients" required><?= htmlspecialchars($recipe['ingredients']) ?></textarea>
        <textarea name="steps" required><?= htmlspecialchars($recipe['steps']) ?></textarea>
        <button type="submit">Update</button>
    </form>
</div>