<?php
// Block search engines + add security headers
header("X-Robots-Tag: noindex, nofollow", true);
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");

session_start();
include '../db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="../header.css">
    <link rel="stylesheet" href="registration.css">
</head>

<body>
 <!-----------Navigation Bar ------------------>
    <?php include '../header.php'; ?>

        <!--  ------------------------------------- -->
    <div class="form-container">

        <h2 class="form-title">Create Your Own Account</h2>

        <form action="register_process.php" method="POST" class="reg-form">

            <div class="row">
                <div class="input-group">
                    <label>Name</label>
                    <input type="text" name="first_name" required>
                </div>

                <div class="input-group">
                    <label>Surname</label>
                    <input type="text" name="last_name" required>
                </div>
            </div>

            <div class="row">
                <div class="input-group">
                    <label>Email</label>
                     <input type="email" name="email" required
                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                            title="Enter a valid email address">
                </div>

                <div class="input-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" required
                           pattern="[0-9]{8}"
                           title="Phone number must contain exactly 8 digits">
                </div>
            </div>

            <div class="row">
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" required
                           pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}"
                           title="Password must contain at least 8 characters, 1 uppercase letter, 1 lowercase letter, and 1 number">
                </div>

                <div class="input-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" required>
                </div>
            </div>

            <div class="btn-wrapper">
                <button type="submit" class="submit-btn">Create Account</button>
            </div>

        </form>

    </div>
   <!-- ================= Footer ================= -->
   <footer class="footer">
        <div class="footer-logo">
            <img src="../assets/img/basilico-footer.png" alt="Basilico Logo">
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