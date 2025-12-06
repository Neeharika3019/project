<?php
// start the session on ALL pages using this header
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-------------Header-------------->
<header>
    <div class="logo">
        <img src="assets/basilico-logo.png" alt="Basilico Logo">
    </div>

    <nav>
      <!-- Static navigation links -->
        <a href="home.php">Home</a>
        <a href="about.php">About</a>
        <a href="menu.php">Menu</a>
        <a href="reservation.php">Reservation</a>
        <a href="order_online.php">Order Online</a>
          
    <!---
         |---------------------------------------------------------------|
         |  LOGIN-BASED NAVIGATION                                       |
         |---------------------------------------------------------------|
         |  The navigation bar dynamically changes based on whether the  |
         |  user is logged in.                                            |
         |                                                               |
         |  - If the user IS logged in:                                   |
         |      • Display a welcome message with the user's first name   |
         |      • Show the Logout button                                 |
         |                                                               |
         |  - If the user is NOT logged in:                               |
         |      • Show the Registration and Login links only             |
         |                                                               |
         |  This is done using PHP sessions (session variables).         |
         |---------------------------------------------------------------|
    --->

        <?php if (isset($_SESSION['user_id'])) { ?>
            <!-- User is logged in -->
            <span class="welcome-user">
              <!--Dispalay the logged-in user's name--->
              <!--Use htmlspecialchars() to prevent XSS-->
                Welcome, <?= htmlspecialchars($_SESSION['first_name']); ?>
            </span>
            <a class="logout-link" href="logout.php">Logout</a>
        <?php } else { ?>
          <!-- Links shown only when user is NOT logged in -->
            <a href="registration.php">Registration</a>
            <a href="login.php">Login</a>
        <?php } ?>
    </nav>
</header>
