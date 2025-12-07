<?php
$conn = new mysqli("localhost", "root", "", "basilico_order");

if ($conn->connect_error) {
    die("Connection failed: " . $conn_order->connect_error);
}
?>