<?php
session_start(); 
include 'db.php'; 

//BASIC BACKEND PROTECTION

// 1. Stop search engines (server-side)
header("X-Robots-Tag: noindex, nofollow");

// 2. Prevent clickjacking (protect against iframe embedding)
header("X-Frame-Options: DENY");

// 3. Prevent MIME-type sniffing
header("X-Content-Type-Options: nosniff");

// 4. Basic security header to reduce XSS risks
header("X-XSS-Protection: 1; mode=block");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basilico</title>
    <link rel="stylesheet" href="menu.css">
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

<?php
$categories = [
    'spaghetti' => 'Basilico’s Authentic Spaghetti',
    'drinks' => 'Drinks',
    'desserts' => 'Desserts'
];

foreach($categories as $dbCategory => $displayTitle):
    echo "<h2 class='title'>$displayTitle</h2>";
    echo "<section class='menu-container'>";

    $stmt = $conn->prepare("SELECT * FROM menu_items WHERE category = ?");
    $stmt->bind_param("s", $dbCategory);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()):
?>
        <div class="menu-card">
            <h3 class="item-title"><?php echo htmlspecialchars($row['name']); ?></h3>
            <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
            <p><?php echo htmlspecialchars($row['description']); ?></p>
            <div class="price">Price: Rs <?php echo htmlspecialchars($row['price']); ?></div>
            
            <button type="button" onclick="window.location.href='orderonline.php'">
                Add to cart
            </button>

        </div>
<?php
    endwhile;
    echo "</section>";
endforeach;
?>

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




