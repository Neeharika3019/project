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

if ($_SESSION['role'] !== 'admin') {
    echo "<script>alert('Access Denied: Admins only'); window.location='menu.php';</script>";
    exit;
}

include "../db.php";

// Fetch menu items
$sql = "SELECT * FROM menu_items";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Menu Items</title>
    <link rel="stylesheet" href="admin_menu_items.css">
</head>
<body>

<!-- Navigation Bar -->
<header>
    <div class="logo">
        <img src="assets/basilico-logo.png" alt="Basilico Logo">
    </div>
    <nav>
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Menu</a>
        <a href="#">Reservation</a>
        <a href="#">Order Online</a>
        <a href="#">Registration</a>
        <a href="#">Login</a>
    </nav>
</header>

<main>
    <h2 class="admin-title">Admin Control Panel for Menu Items</h2>

    <a href="add_menu_item.php" class="add-item-btn">Add a New Menu Item</a>

    <table class="menu-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['item_id']) ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td class="description"><?= htmlspecialchars($row['description']) ?></td>
                <td>Rs <?= htmlspecialchars($row['price']) ?></td>
                <td><img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="menu-img"></td>
                <td>
                    <a href="edit_menu_item.php?id=<?= $row['item_id'] ?>">Edit</a> |
                    <a href="delete_menu_item.php?id=<?= $row['item_id'] ?>" onclick="return confirm('Delete this item?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</main>

<footer class="footer">
    <div class="footer-logo">
        <img src="assets/basilico-footer.png" alt="Basilico Logo">
    </div>

    <div class="footer-columns">
        <div class="footer-column">
            <h4>Doormat Navigation</h4>
            <p>Home</p>
            <p>Menu</p>
            <p>Reservation</p>
            <p>Order Online</p>
            <p>Registration</p>
            <p>Login</p>
        </div>
        <div class="footer-column">
            <h4>Contact</h4>
            <p>📍 Port Louis, Mauritius</p>
            <p>📞 +230 5555 1234</p>
            <p>✉️ contact@basilico.mu</p>
        </div>
        <div class="footer-column">
            <h4>Opening Hours</h4>
            <p>Mon-Fri: 11 00 AM - 10 00 PM</p>
            <p>Sat-Sun: 12 00 PM - 11.30 PM</p>
        </div>
    </div>
</footer>

</body>
</html>
