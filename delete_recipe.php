<?php
include 'session.php';
include 'db.php';
$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM recipes WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $id, $_SESSION['user_id']);
$stmt->execute();
header("Location: dashboard.php");