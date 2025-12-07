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

$conn->query("DELETE FROM specials WHERE id = $id");

header("Location: specials_view.php");
exit();
?>
