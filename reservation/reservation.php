<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php"); // redirect to login page
    exit();
}

// Connect to database
include '../db.php';

$message = "";

// Fetch user info from users table
$user_id = $_SESSION['user_id'];
$user_sql = "SELECT first_name, last_name, email, phone FROM users WHERE user_id='$user_id'";
$user_result = $conn->query($user_sql);

if (!$user_result || $user_result->num_rows == 0) {
    die("User not found.");
}

$user = $user_result->fetch_assoc();

// Handle reservation form submission
if (isset($_POST['reserve'])) {
    $date = $_POST['date'];
    $people = $_POST['people'];
    $time = $_POST['time'];

    $sql = "INSERT INTO reservations (user_id, date, phone, people, time) 
        VALUES ('$user_id', '$date', '{$user['phone']}', '$people', '$time')";

    if ($conn->query($sql) === TRUE) {
        $message = "Reservation successfully made!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Make a Reservation</title>
    <link rel="stylesheet" href="reservation.css">
</head>
<body>

<?php include '../header.php'; ?>

<section class="reservation-section">
    <h1>Book Your Table</h1>
    <p class="subtitle">Reserve a table easily and quickly</p>

    <?php if ($message != "") echo "<p style='color: green; font-weight: bold;'>$message</p>"; ?>

    <div class="reservation-container">
        <form class="reservation-form" method="POST">
            <label for="name">Name</label>
            <input type="text" id="name" value="<?= $user['first_name'] . ' ' . $user['last_name'] ?>" disabled>

            <label for="email">Email</label>
            <input type="email" id="email" value="<?= $user['email'] ?>" disabled>

            <label for="phone">Phone</label>
            <input type="text" id="phone" value="<?= $user['phone'] ?>" disabled>

            <label for="date">Date</label>
            <input type="date" name="date" id="date" required>

            <label for="people">Number of People</label>
            <input type="number" name="people" id="people" min="1" required>

            <label for="time">Time</label>
            <input type="time" name="time" id="time" required>

            <button type="submit" name="reserve" class="reserve-btn">Reserve</button>
        </form>

        <div class="reservation-image">
            <img src="../assets/img/pasta.png" alt="Restaurant Table">
        </div>
    </div>
</section>

<footer class="footer">
        <div class="footer-logo">
            <img src="../assets/basilico-footer.png" alt="Basilico Logo">
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
</html>
