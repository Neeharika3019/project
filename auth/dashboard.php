<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<body>
    <h2>Welcome, <?php echo $_SESSION['first_name']; ?>!</h2>
    <p>You are now logged in.</p>
</body>
</html>
