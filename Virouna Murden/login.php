<?php
// Block search engines + add security headers
header("X-Robots-Tag: noindex, nofollow", true);
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
  <!----------------Navigation Bar --------------->
    <?php include 'header.php'; ?>


    <div class="login-container">

        <h2 class="login-title">Log In Your Account</h2>

        <form action="login_process.php" method="POST" class="login-form">

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" id="password" name="password" required>
                <i class="fa-solid fa-eye" id="togglePassword"></i>
            </div>

            <div class="btn-wrapper">
                <button type="submit" class="login-btn">Login</button>
            </div>

        </form>

    </div>
    <!-- ================= Footer ================= -->
   <footer class="footer">
        <div class="footer-logo">
            <img src="assets/img/basilico-footer.png" alt="Basilico Logo">
        </div>

        <div class="footer-columns">
            <div class="footer-column">
                <h4>Doormat Navigation</h4>
                <p>Home</p>
                <p>Menu</p>
                <p>Reservation</p>
                <p>Order Online</p>
                <p>Registration</p>
                <p>Login</p>
            </div>
            <div class="footer-column">
                <h4>Contact</h4>
                <p>📍 Port Louis, Mauritius</p>
                <p>📞 +230 5555 1234</p>
                <p>✉️ contact@basilico.mu</p>
            </div>
            <div class="footer-column">
                <h4>Opening Hours</h4>
                <p>Mon-Fri: 11 00 AM - 10 00 PM</p>
                <p>Sat-Sun: 12 00 PM - 11.30 PM</p>
            </div>
        </div>
    </footer>
</body>
<script>
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function () {
        // Show/Hide password
        const type = password.type === "password" ? "text" : "password";
        password.type = type;

        // Toggle between eye and eye-slash icons
        this.classList.toggle("fa-eye");
        this.classList.toggle("fa-eye-slash");
    });
</script>