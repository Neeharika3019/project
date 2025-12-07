<?php
session_start();
include "db_menu.php";   // use real database for menu_items + users
include "db_order.php";  // use new database for storing orders
include "db_connect.php"; 

// Load menu items from DB (instead of basilico_menu.php)
$menu = [];
$sql = "SELECT item_id, name AS item_name, price FROM menu_items";
$result = $conn_menu->query($sql);

if (!$result) {
    die("SQL ERROR: " . $conn_menu->error);
}

while ($row = $result->fetch_assoc()) {
    $menu[] = $row;
}

$specials = [];
$sql2 = "SELECT id AS item_id, dish_name AS item_name, price FROM specials";
$result2 = $conn->query($sql2);

while ($row2 = $result2->fetch_assoc()) {
    $specials[] = $row2;
}

// --- RECEIVE SPECIAL ITEM ID FROM ?id= ----
if (isset($_GET['id'])) {
    $special_id = intval($_GET['id']);

    // Search the item inside $specials array (or load it from DB)
    $sqlSpecial = "SELECT id, dish_name, price FROM specials WHERE id = $special_id LIMIT 1";
    $resultSpecial = $conn->query($sqlSpecial);

    if ($resultSpecial && $resultSpecial->num_rows > 0) {
        $special = $resultSpecial->fetch_assoc();

        // ADD TO CART AUTOMATICALLY
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (!isset($_SESSION['cart'][$special['id']])) {
            $_SESSION['cart'][$special['id']] = 1;
        } else {
            $_SESSION['cart'][$special['id']]++;
        }

        // Success message
        $_SESSION['flash_success'] = $special['dish_name'] . " added to cart!";
    } else {
        $_SESSION['flash_error'] = "Invalid item selected.";
    }

    // Prevent multiple additions on page refresh
    header("Location: orderonline.php");
    exit();
}

require_once "auth.php";     // contains is_logged_in()

// Redirect to login page if the user is not logged in.
if (!is_logged_in()) {
    // We redirect to the login page. The existing login link already has a 'redirect' parameter,
    // so we'll use the same logic to bring the user back here after they log in.
    header('Location: ../auth/login.php?redirect=orderonline.php');
    exit(); // It's crucial to call exit() after a header redirect to stop the script.
}


require_once "cart_logic.php";

// ----------  TOTAL CALCULATION ----------
$total_display = 0;

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $qty) {

        $item_price = null;

        // 1️⃣ Check menu_items
        foreach ($menu as $m) {
            if ($m['item_id'] == $id) {
                $item_price = $m['price'];
                break;
            }
        }

        // 2️⃣ Check specials
        if ($item_price === null) {
            foreach ($specials as $s) {
                if ($s['item_id'] == $id) {
                    $item_price = $s['price'];
                    break;
                }
            }
        }

        // Add to total
        if ($item_price !== null) {
            $total_display += ($item_price * $qty);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Basilico – Order Online</title>
    <link rel="stylesheet" href="orderonline.css">
</head>
<body>

<header>
    <div class="logo">
        <img src="logo.jpeg" alt="Basilico Logo">
        <div>
            <strong>BASILICO</strong>
            <div class="user-info">
                <?php if (is_logged_in()): ?>
                    Logged in as <?= htmlspecialchars($_SESSION['full_name']) ?>
                    – <a href="logout.php">Logout</a>
                <?php else: ?>
                    Guest – <a href="../authlogin.php?redirect=orderonline.php">Login</a> /
                    <a href="register.php">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <nav>
        <ul>
            <li><a href="home.php" >Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="reservation.php">Reservation</a></li>
            <li><a class="active" href="#">OrderOnline</a></li>
            <li><a href="register.php">Registration</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>

<main>

    <!-- Combined Error / success messages -->
    <div class="messages">
        <!-- Display flash messages from other pages (like addtocart.php) -->
        <?php
        if (isset($_SESSION['flash_success'])) {
            echo '<div class="success">' . htmlspecialchars($_SESSION['flash_success']) . '</div>';
            unset($_SESSION['flash_success']);
        }
        if (isset($_SESSION['flash_error'])) {
            echo '<div class="error">' . htmlspecialchars($_SESSION['flash_error']) . '</div>';
            unset($_SESSION['flash_error']);
        }
        ?>

        <!-- Display messages generated by cart_logic.php -->
        <?php if (isset($errors) && !empty($errors)): ?>
            <?php foreach ($errors as $e): ?>
                <div class="error">• <?= htmlspecialchars($e) ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (isset($success) && $success !== ''): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
    </div>

    <section class="hero">
        <h1>How To Order Online?</h1>
        <img src="../assets/img/tomato_spaghetti.webp" alt="Pasta Dish">
    </section>

    <section class="step-bar">
        <div class="step"><div class="step-number">1</div><div class="step-text">Sign in / Login</div></div>
        <div class="step"><div class="step-number">2</div><div class="step-text">Place Order</div></div>
        <div class="step"><div class="step-number">3</div><div class="step-text">Delivery / Pickup</div></div>
    </section>

    <section class="menu-btn-wrapper">
        <a href="menu.php">
            <button class="menu-btn" type="button">Menu</button>
        </a>
    </section>


    <section class="order-table-section">
        <h3>🍽 Buon Appetito!<br><br>
        Check your meals, update quantities, and enjoy your Italian feast.</h3>

        <form method="post">
            <input type="hidden" name="action" value="update">
            <table>
                <tr><th>Item</th><th>Quantity</th><th>Price (Rs)</th></tr>

                <?php if (!empty($_SESSION['cart'])): ?>

    <?php foreach ($_SESSION['cart'] as $id => $qty): ?>

        <?php
        $found = false;

        // 1️⃣ Check menu_items (basilico_menu)
        foreach ($menu as $m) {
            if ($m['item_id'] == $id) {
                $item_name = $m['item_name'];
                $item_price = $m['price'];
                $found = true;
                break;
            }
        }

        // 2️⃣ Check specials (basilico_db)
        if (!$found) {
            foreach ($specials as $s) {
                if ($s['item_id'] == $id) {
                    $item_name = $s['item_name'];
                    $item_price = $s['price'];
                    $found = true;
                    break;
                }
            }
        }

        if (!$found) continue;
        ?>

        <tr>
            <td><?= htmlspecialchars($item_name) ?></td>
            <td><input type="number" name="qty[<?= $id ?>]" value="<?= $qty ?>" min="0"></td>
            <td><?= number_format($item_price * $qty, 2) ?></td>
        </tr>

    <?php endforeach; ?>

<?php else: ?>

    <tr><td colspan="3">No items in cart yet.</td></tr>

<?php endif; ?>

            </table>

          <button class="cart-btn" type="submit">Update Cart</button>

        </form>

        <div class="total-amount">Total Amount: Rs <?= number_format($total_display, 2) ?></div>
    </section>

    <section class="delivery-strip">
 
            <form method="post">
                <button class="delivery-btn" type="button">Delivery / Pick Up</button>

                <div class="delivery-form">
                    <label><input type="radio" name="method" value="delivery"> Delivery</label>
                    <label><input type="radio" name="method" value="pickup"> Pickup</label>
                    <br><br>
                    <label>Address:
                        <input type="text" name="address" placeholder="Required only for Delivery">
                    </label>

                    <input type="hidden" name="action" value="checkout">

                    <input type="hidden" name="total" value="<?= $total_display ?>">
                    <br><br>
                    <button type="submit">Confirm Order</button>
                </div>
            </form>
  
    </section>



    <section class="row">
        <img src="parmessan_spagetti.jpg" alt="">
        <img src="lemonade.png" alt="">
        <img src="spaghetti_basilico1.jpg" alt="">
    </section>
</main>

<footer>
    <div class="footer-logo-strip">
        <img src="red_basilico.jpeg" alt="">
    </div>

    <div class="footer-content">
        <div>
            <div class="footer-title">Doormat Navigation</div>
            <ul class="footer-list">
                <li>Home</li><li>About</li><li>Menu</li>
                <li>Reservation</li><li>Order Online</li>
                <li>Registration</li><li>Login</li>
            </ul>
        </div>

        <div>
            <div class="footer-title">Contact</div>
            <p class="footer-small">
                Port Louis, Mauritius<br>
                +230 5555 1234<br>
                contact@basilico.mu
            </p>
        </div>

        <div>
            <div class="footer-title">Opening Hours</div>
            <p class="footer-small">
                Mon–Fri: 11 AM – 10 PM<br><br>
                Sat–Sun: 12 PM – 11:30 PM
            </p>
        </div>
    </div>
</footer>

</body>
</html>
