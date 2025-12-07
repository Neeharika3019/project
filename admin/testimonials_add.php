<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include "../db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $rating = $_POST['rating'];
    $text = $_POST['text'];

    $stmt = $conn->prepare("INSERT INTO testimonials (username, rating, text, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sis", $username, $rating, $text);
    $stmt->execute();

    header("Location: testimonials_view.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Testimonial</title>
</head>
<body>

<h2>Add Testimonial</h2>

<a href="testimonials_view.php">⬅ Back</a>

<form method="POST">

    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Rating (1–5):</label><br>
    <input type="number" name="rating" min="1" max="5" required><br><br>

    <label>Text:</label><br>
    <textarea name="text" required></textarea><br><br>

    <button type="submit">Add Testimonial</button>

</form>

</body>
</html>
