<?php
session_start();

// Remove all session variables
session_unset();

// Destroy the current session
session_destroy();

// Redirect user to home page
header("Location: ../home.php");
exit;
?>
