<?php
session_set_cookie_params([
    'lifetime' => 0   // cookie disappears when browser closes
]);

session_start();

// Login Protection
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: ../login.php");
    exit;
}

// Block non-admin users
if ($_SESSION['role'] !== 'admin') {
    echo "<script>alert('Access Denied: Admins only'); window.location='menu.php';</script>";
    exit;
}

include "../db.php";

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM menu_items WHERE item_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: admin_menu_items.php");
