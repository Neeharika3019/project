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

// Database connection
include "../db.php";


// Get item ID from URL
$id = $_GET['id'];

// Fetch current item from database
$stmt = $conn->prepare("SELECT * FROM menu_items WHERE item_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Check if a new image was uploaded
    if (!empty($_FILES['image']['name'])) {
        $image = "assets/" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);

        $stmt = $conn->prepare("UPDATE menu_items SET name=?, description=?, price=?, image=? WHERE item_id=?");
        $stmt->bind_param("sdssi", $name, $description, $price, $image, $id);
    } else {
        $stmt = $conn->prepare("UPDATE menu_items SET name=?, description=?, price=? WHERE item_id=?");
        $stmt->bind_param("sdsi", $name, $description, $price, $id);
    }

    $stmt->execute();
    header("Location: admin_menu_items.php");
    exit;
}
?>

<link rel="stylesheet" href="edit_menu_item.css">

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

<h2 class="form-title">
    Currently editing: <span class="item-name"><?= htmlspecialchars($product['name']) ?></span>
</h2>

<form method="POST" enctype="multipart/form-data" class="product-form">
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" placeholder="Item Name" required>
    
    <textarea name="description" placeholder="Description (optional)"><?= htmlspecialchars($product['description']) ?></textarea>
    
    <input type="number" step="1" name="price" value="<?= htmlspecialchars($product['price']) ?>" placeholder="Price" required>
    
    <label class="file-label">Change Image (optional)</label>
    <input type="file" name="image">

    <div class="image-preview">
        <p>Current Image:</p>
        <?php if (!empty($product['image']) && file_exists($product['image'])): ?>
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        <?php else: ?>
            <p>No image uploaded</p>
        <?php endif; ?>
    </div>
    
    <button type="submit">Update menu item</button>
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
