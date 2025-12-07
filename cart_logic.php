<?php
// This file handles ALL cart actions: update quantities + checkout.

$errors = [];
$success = "";

$action = $_POST['action'] ?? null;

// If no action, nothing to do
if (!$action) {
    return;
}

// ------------------------------------------------------------
// 1️⃣  UPDATE CART QUANTITIES
// ------------------------------------------------------------
if ($action === "update") {

    if (!isset($_POST['qty']) || !is_array($_POST['qty'])) {
        $errors[] = "Invalid cart update request.";
        return;
    }

    foreach ($_POST['qty'] as $id => $qty) {

        // Force qty to be at least 0
        $qty = max(0, (int)$qty);

        if ($qty === 0) {
            unset($_SESSION['cart'][$id]);   // remove item
        } else {
            $_SESSION['cart'][$id] = $qty;   // update quantity
        }
    }

    $success = "Cart updated successfully!";
    return;
}



// ------------------------------------------------------------
// 2️⃣  CHECKOUT — SAVE ORDER TO DATABASE
// ------------------------------------------------------------
if ($action === "checkout") {

    if (!isset($_SESSION['user_id'])) {
        $errors[] = "You must be logged in to place an order.";
        return;
    }

    if (empty($_SESSION['cart'])) {
        $errors[] = "Your cart is empty.";
        return;
    }

    $method = $_POST['method'] ?? "";
    $address = trim($_POST['address'] ?? "");

    if ($method !== "delivery" && $method !== "pickup") {
        $errors[] = "Please select Delivery or Pickup.";
        return;
    }

    if ($method === "delivery" && $address === "") {
        $errors[] = "Address is required for delivery orders.";
        return;
    }

    $user_id = $_SESSION['user_id'];

    // ------------------------------------------------------------
    //  CALCULATE TOTAL
    // ------------------------------------------------------------
    $total = 0;
    $items = [];

    foreach ($_SESSION['cart'] as $cart_id => $qty) {
        foreach ($menu as $m) {
            if ($m['item_id'] == $cart_id) {
                $lineTotal = $m['price'] * $qty;
                $total += $lineTotal;

                $items[] = [
                    "item_id" => $cart_id,
                    "qty" => $qty,
                    "price" => $m['price']
                ];

                break;
            }
        }
    }

    if ($total <= 0) {
        $errors[] = "Cart total cannot be zero.";
        return;
    }


    // ------------------------------------------------------------
    //  SAVE ORDER INTO THE COMBINED DATABASE (USING $conn)
    // ------------------------------------------------------------

    // Insert into orders table
    $stmt = $conn->prepare("
        INSERT INTO orders (user_id, total_amount, delivery_type, address, order_status)
        VALUES (?, ?, ?, ?, 'Pending')
    ");
    $stmt->bind_param("idss", $user_id, $total, $method, $address);
    $stmt->execute();

    $order_id = $stmt->insert_id;


    // ------------------------------------------------------------
    //  SAVE ORDER ITEMS
    // ------------------------------------------------------------
    $stmt_item = $conn->prepare("
        INSERT INTO order_items (order_id, item_id, quantity, price)
        VALUES (?, ?, ?, ?)
    ");

    foreach ($items as $it) {
        $stmt_item->bind_param(
            "iiid",
            $order_id,
            $it['item_id'],
            $it['qty'],
            $it['price']
        );
        $stmt_item->execute();
    }


    // ------------------------------------------------------------
    //  CLEAR CART
    // ------------------------------------------------------------
    $_SESSION['cart'] = [];


    // ------------------------------------------------------------
    //  SUCCESS MESSAGE
    // ------------------------------------------------------------
    $success = "Order placed successfully! Your Order ID is #$order_id";

    return;
}
?>
