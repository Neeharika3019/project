<?php
session_set_cookie_params([
    'lifetime' => 0   // cookie disappears when browser closes
]);

session_start();

// Login Protection
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    echo "<script>alert('Access Denied: Admins only'); window.location='menu.php';</script>";
    exit;
}

include 'db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Handle file upload
    $image = $_FILES['image']['name'];
    $target = "assets/" . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO menu_items (name, description, price, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $name, $description, $price, $image);
    $stmt->execute();
    $stmt->close();

    header("Location: admin_menu_items.php");
}
?>

<link rel="stylesheet" href="add_menu_item.css">

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

<h2 class="form-title">Please fill in the details for adding a new menu item.</h2>

<form method="POST" enctype="multipart/form-data" class="product-form">
    <input type="text" name="name" placeholder="Item Name" required>
    <textarea name="description" placeholder="Description (optional)"></textarea>
    <input type="number" step="1" name="price" placeholder="Price" required>
    <input type="file" name="image" required>
    <button type="submit">Add Menu Item</button>
</form>

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
