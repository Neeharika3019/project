<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dish_name = $_POST['dish_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];

    $stmt = $conn->prepare("INSERT INTO specials (dish_name, price, description, image_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $dish_name, $price, $description, $image_url);
    $stmt->execute();

    header("Location: specials_view.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Special</title>
</head>
<body>

<h2>Add New Special</h2>

<a href="specials_view.php">⬅ Back</a>

<form method="POST">
    <label>Dish Name:</label><br>
    <input type="text" name="dish_name" required><br><br>

    <label>Price:</label><br>
    <input type="number" name="price" step="0.01" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" required></textarea><br><br>

    <label>Image URL:</label><br>
    <input type="text" name="image_url" required><br><br>

    <button type="submit">Add Special</button>
</form>

</body>
</html>

