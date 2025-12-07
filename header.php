<?php
// start the session on ALL pages using this header
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-------------Header-------------->
<header>
    <div class="logo">
        <img src="../assets/img/basilico-logo.png">
    </div>

    <nav>
      <!-- Static navigation links -->
      <a href="/basilico/homepage/home.php">Home</a>
      <a href="/basilico/about/about.php">About</a>
      <a href="/basilico/menu/menu.php">Menu</a>
      <a href="../reservation/reservation.php">Reservation</a>
      <a href="../order/orderonline.php">Order Online</a>

          
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
            <a class="logout-link" href="/basilico/logout.php">Logout</a>
        <?php } else { ?>
          <!-- Links shown only when user is NOT logged in -->
          <a href="/basilico/auth/registration.php">Registration</a>
          <a href="/basilico/auth/login.php">Login</a>
        <?php } ?>
    </nav>
</header>
