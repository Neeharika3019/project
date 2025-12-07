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

$id = $_GET['id'];

// Fetch user info
$user = $conn->query("SELECT * FROM users WHERE user_id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];
    $role       = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=?, phone=?, role=? WHERE user_id=?");
    $stmt->bind_param("sssssi", $first_name, $last_name, $email, $phone, $role, $id);
    $stmt->execute();

    header("Location: users_view.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>

<h2>Edit User</h2>
<a href="users_view.php">⬅ Back</a>

<form method="POST">
    <label>First Name:</label><br>
    <input type="text" name="first_name" value="<?= $user['first_name'] ?>" required><br><br>

    <label>Last Name:</label><br>
    <input type="text" name="last_name" value="<?= $user['last_name'] ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= $user['email'] ?>" required><br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone" value="<?= $user['phone'] ?>" required><br><br>

    <label>Role:</label><br>
    <select name="role">
        <option value="customer" <?= $user['role']=='customer'?'selected':'' ?>>Customer</option>
        <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
    </select><br><br>

    <button type="submit">Save Changes</button>
</form>

</body>
</html>
