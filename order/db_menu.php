<?php
$conn_menu = new mysqli("localhost", "root", "", "basilico_menu");

if ($conn_menu->connect_error) {
    die("Connection failed: " . $conn_menu->connect_error);
}
?>
