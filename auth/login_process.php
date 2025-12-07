<?php
session_start();

// CONNECT TO DATABASE
include '../db.php';

$email = $_POST['email'];
$password = $_POST['password'];

// FIND USER BY EMAIL
// Using a prepared statement to securely check the user's email.
// This prevents SQL injection by separating SQL code from user input
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // CHECK PASSWORD
    if (password_verify($password, $user['password_hash'])) {

    // Prevent session fixation attacks
    session_regenerate_id(true);

    // START SESSION
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['role'] = $user['role'];


        // If user came from a protected page, send them back there
        if (isset($_SESSION['redirect_to'])) {
            $redirect_page = $_SESSION['redirect_to'];
            unset($_SESSION['redirect_to']); // remove after use
            header("Location: $redirect_page");
            exit;
        }

        // Role-Based Redirection
    if ($user['role'] === 'admin') {
        header("Location: ../admin/admin_home.php");
        exit;
    } else {
     header("Location: ../homepage/home.php");
     exit;

    }

    } else {
        echo "<script>alert('Incorrect password'); window.location='login.php';</script>";
    }

} else {
    echo "<script>alert('Email not found'); window.location='login.php';</script>";
}
?>
