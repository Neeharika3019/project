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

$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
</head>
<body>

<h2>User Accounts</h2>

<a href="admin_home.php">⬅ Back to Admin Home</a>

<table border="1" cellpadding="10" cellspacing="0">
<tr>
    <th>ID</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Role</th>
    <th>Created At</th>
    <th>Actions</th>
</tr>

<?php while ($row = $users->fetch_assoc()): ?>
<tr>
    <td><?= $row['user_id'] ?></td>
    <td><?= $row['first_name'] ?></td>
    <td><?= $row['last_name'] ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= $row['phone'] ?></td>
    <td><?= $row['role'] ?></td>
    <td><?= $row['created_at'] ?></td>
    <td>
        <a href="users_edit.php?id=<?= $row['user_id'] ?>">✏ Edit</a> |
        <a href="users_change_password.php?id=<?= $row['user_id'] ?>">🔑 Change Password</a> |
        <a href="users_delete.php?id=<?= $row['user_id'] ?>" onclick="return confirm('Delete this user?');">❌ Delete</a>
    </td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>
