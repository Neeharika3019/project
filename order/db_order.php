<?php
$conn_order = new mysqli("localhost", "root", "", "basilico_order");

if ($conn_order->connect_error) {
    die("Connection failed: " . $conn_order->connect_error);
}
?>
