<?php include 'session.php'; include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];
    $photo = $_FILES['photo']['name'];
    $target = "uploads/" . basename($photo);
    move_uploaded_file($_FILES['photo']['tmp_name'], $target);

    $stmt = $conn->prepare("INSERT INTO recipes (user_id, title, ingredients, steps, photo) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $_SESSION['user_id'], $title, $ingredients, $steps, $photo);
    $stmt->execute();
    header("Location: dashboard.php");
}
?>
<link rel="stylesheet" href="css/style.css">
<header><img src="assets/logo.png" class="logo"><nav><a href="dashboard.php">Dashboard</a></nav></header>
<div class="container">
    <form method="post" enctype="multipart/form-data">
        <h2>Add Recipe</h2>
        <input type="text" name="title" placeholder="Recipe Title" required>
        <textarea name="ingredients" placeholder="Ingredients" required></textarea>
        <textarea name="steps" placeholder="Cooking Steps" required></textarea>
        <input type="file" name="photo" accept="image/*" required>
        <button type="submit">Save Recipe</button>
    </form>
</div>