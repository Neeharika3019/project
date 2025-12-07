<?php
session_start();

// Use the unified database
include 'db.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;
$delivery_type = $_POST['delivery_type'] ?? 'Delivery';

// Fetch cart items
$sql = "
SELECT c.item_id, c.quantity, m.price
FROM cart c
JOIN menu_items m ON c.item_id = m.item_id
WHERE c.user_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: orderonline.php");
    exit;
}

// Compute total & store items temporarily
$items = [];
$total = 0;

while ($row = $result->fetch_assoc()) {
    $items[] = $row;
    $total += $row['quantity'] * $row['price'];
}

// 1) Insert order
$insertOrder = $conn->prepare("
    INSERT INTO orders (user_id, total_amount, delivery_type, order_status)
    VALUES (?, ?, ?, 'Pending')
");
$insertOrder->bind_param("ids", $user_id, $total, $delivery_type);
$insertOrder->execute();
$order_id = $insertOrder->insert_id;

// 2) Insert each order item
$insertItem = $conn->prepare("
    INSERT INTO order_items (order_id, item_id, quantity, price)
    VALUES (?, ?, ?, ?)
");

foreach ($items as $it) {
    $insertItem->bind_param("iiid", $order_id, $it['item_id'], $it['quantity'], $it['price']);
    $insertItem->execute();
}

// 3) Clear cart
$deleteCart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
$deleteCart->bind_param("i", $user_id);
$deleteCart->execute();

// 4) Redirect to success page
header("Location: order_success.php?order_id=" . $order_id);
exit;
