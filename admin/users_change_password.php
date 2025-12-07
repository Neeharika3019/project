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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $new_password = $_POST['new_password'];

    // Hash password
    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET password_hash=? WHERE user_id=?");
    $stmt->bind_param("si", $password_hash, $id);
    $stmt->execute();

    header("Location: users_view.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
</head>
<body>

<h2>Change User Password</h2>
<a href="users_view.php">⬅ Back</a>

<form method="POST">
    <label>New Password:</label><br>
    <input type="password" name="new_password" required><br><br>

    <button type="submit">Update Password</button>
</form>

</body>
</html>
