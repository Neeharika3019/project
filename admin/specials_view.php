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

// Fetch all specials
$specials = $conn->query("SELECT * FROM specials");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Specials</title>
</head>
<body>

<h2>Specials List</h2>

<a href="admin_home.php">⬅ Back to Admin Home</a> | 
<a href="specials_add.php">➕ Add New Special</a>

<table border="1" cellpadding="10" cellspacing="0">
<tr>
    <th>ID</th>
    <th>Dish Name</th>
    <th>Price</th>
    <th>Description</th>
    <th>Image</th>
    <th>Actions</th>
</tr>

<?php while ($row = $specials->fetch_assoc()): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['dish_name'] ?></td>
    <td><?= $row['price'] ?></td>
    <td><?= $row['description'] ?></td>
    <td><img src="<?= $row['image_url'] ?>" width="80"></td>
    <td>
        <a href="specials_edit.php?id=<?= $row['id'] ?>">✏ Edit</a> |
        <a href="specials_delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this special?');">❌ Delete</a>
    </td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>

