<?php
session_start();

// 1️⃣ Check if item ID is provided
if (!isset($_GET['id'])) {
    header("Location: menu.php");
    exit();
}

$item_id = (int)$_GET['id'];

// 2️⃣ Create cart if it does not exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// 3️⃣ Add or update quantity
if (!isset($_SESSION['cart'][$item_id])) {
    $_SESSION['cart'][$item_id] = 1;  // first time added
} else {
    $_SESSION['cart'][$item_id]++;     // increment quantity
}

// 4️⃣ Redirect to orderonline page
header("Location: orderonline.php");
exit();
?>
