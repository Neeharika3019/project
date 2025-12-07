<?php
// Block search engines + add security headers
header("X-Robots-Tag: noindex, nofollow", true);
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
session_start();

// Only admin can access these pages
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Home</title>
    <link rel="stylesheet" href="admin_home.css">
</head>
<body>

<div class="admin-container">

    <h1>Admin Panel</h1>
    <p>Welcome, <?php echo $_SESSION['first_name']; ?>!</p>

<ul class="admin-menu">
    <li><a href="specials_view.php">Manage Specials</a></li>
    <li><a href="testimonials_view.php">Manage Testimonials</a></li>
    <li><a href="admin_menu_items.php"> Manage Menu</a></li>
    <li><a href="users_view.php">Manage Users</a></li>
    <li><a href="logout.php" class="logout">Logout</a></li>
    
</ul>


</div>

</body>
</html>