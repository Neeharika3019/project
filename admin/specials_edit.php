<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
include "../db.php";

// Get ID
$id = $_GET['id'];

// Fetch special row
$special = $conn->query("SELECT * FROM specials WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dish_name = $_POST['dish_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];

    $stmt = $conn->prepare("UPDATE specials SET dish_name=?, price=?, description=?, image_url=? WHERE id=?");
    $stmt->bind_param("sdssi", $dish_name, $price, $description, $image_url, $id);
    $stmt->execute();

    header("Location: specials_view.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Special</title>
</head>
<body>

<h2>Edit Special</h2>
<a href="specials_view.php">⬅ Back</a>

<form method="POST">
    <label>Dish Name:</label><br>
    <input type="text" name="dish_name" value="<?= $special['dish_name'] ?>" required><br><br>

    <label>Price:</label><br>
    <input type="number" name="price" step="0.01" value="<?= $special['price'] ?>" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" required><?= $special['description'] ?></textarea><br><br>

    <label>Image URL:</label><br>
    <input type="text" name="image_url" value="<?= $special['image_url'] ?>" required><br><br>

    <button type="submit">Save Changes</button>
</form>

</body>
</html>
