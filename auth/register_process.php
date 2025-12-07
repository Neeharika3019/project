<?php
include '../db.php';  // Make sure this file has your DB connection

// Get form values
$first_name = $_POST['first_name'];
$last_name  = $_POST['last_name'];
$email      = $_POST['email'];
$phone      = $_POST['phone'];
$password   = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// ------------ BASIC VALIDATION ----------------

// Check password match
if ($password !== $confirm_password) {
    echo "<script>alert('Passwords do not match. Please try again.'); window.history.back();</script>";
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Invalid email address.'); window.history.back();</script>";
    exit;
}

// Validate phone number (exactly 8 digits)
if (!preg_match('/^[0-9]{8}$/', $phone)) {
    echo "<script>alert('Phone number must contain 8 digits.'); window.history.back();</script>";
    exit;
}
//  CHECK IF EMAIL ALREADY EXISTS
$check_email = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
$check_email->bind_param("s", $email);
$check_email->execute();
$check_email->store_result();

if ($check_email->num_rows > 0) {
    echo "<script>alert('Email already registered. Please log in instead.'); window.location='login.php';</script>";
    exit;
}

// Hash password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// ------------ INSERT INTO DATABASE -------------
// This INSERT uses a prepared statement for security. It protects the system
// from SQL injection by binding user inputs separately from the SQL command.
// This ensures that no malicious input can break or manipulate the database query.
$stmt = $conn->prepare("
    INSERT INTO users (first_name, last_name, email, phone, password_hash)
    VALUES (?, ?, ?, ?, ?)
");

$stmt->bind_param("sssss", $first_name, $last_name, $email, $phone, $hashed_password);

if ($stmt->execute()) {
    echo "<script>alert('Account Created Successfully!'); window.location='login.php';</script>";
} else {
    echo "<script>alert('Error creating account.'); window.history.back();</script>";
}

$stmt->close();
