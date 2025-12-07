<?php
// auth.php

// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in
 * Returns TRUE if session contains user ID and name
 */
function is_logged_in(): bool {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Optional helper:
 * Forces the user to log in before accessing a page
 */
function require_login(string $redirectTo = null) {
    if (!is_logged_in()) {
        $redirect = $redirectTo ?? $_SERVER['REQUEST_URI'];
        header("Location: login.php?redirect=" . urlencode($redirect));
        exit;
    }
}
