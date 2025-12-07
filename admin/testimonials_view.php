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

// Fetch testimonials
$result = $conn->query("SELECT * FROM testimonials ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Testimonials</title>
</head>
<body>

<h2>Testimonials List</h2>

<a href="admin_home.php">⬅ Back to Admin Home</a> | 
<a href="testimonials_add.php">➕ Add Testimonial</a>

<table border="1" cellpadding="10" cellspacing="0">
<tr>
    <th>ID</th>
    <th>Username</th>
    <th>Rating</th>
    <th>Text</th>
    <th>Created At</th>
    <th>Actions</th>
</tr>

<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['username'] ?></td>
    <td><?= $row['rating'] ?></td>
    <td><?= $row['text'] ?></td>
    <td><?= $row['created_at'] ?></td>
    <td>
        <a href="testimonials_delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this testimonial?');">❌ Delete</a>
    </td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>
