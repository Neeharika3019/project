<?php
$order_id = (int)($_GET['order_id'] ?? 0);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Successful</title>
</head>
<body>

<h2>🎉 Your Order Has Been Placed!</h2>
<p>Your order number: <strong>#<?= $order_id; ?></strong></p>

<a href="menu.php">Continue Ordering</a>

</body>
</html>
