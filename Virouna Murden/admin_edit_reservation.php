<?php
session_set_cookie_params([
    'lifetime' => 0   // cookie disappears when browser closes
]);

session_start();

// Login Protection
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit;
}

// Connect to database
$connection = new mysqli("localhost", "root", "", "db_basilico");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if reservation ID is provided
if (!isset($_GET['id'])) {
    die("No reservation ID provided.");
}

$reservation_id = $_GET['id'];

// Handle form submission for update
if (isset($_POST['update'])) {
    $date = $_POST['date'];
    $phone = $_POST['phone'];
    $people = $_POST['people'];
    $time = $_POST['time'];

    $update_sql = "UPDATE reservations 
                   SET date='$date', phone='$phone', people='$people', time='$time' 
                   WHERE reservation_id='$reservation_id'";

    if ($connection->query($update_sql) === TRUE) {
        $message = "Reservation updated successfully!";
    } else {
        $message = "Error updating reservation: " . $connection->error;
    }
}

// Handle delete
if (isset($_POST['delete'])) {
    $delete_sql = "DELETE FROM reservations WHERE reservation_id='$reservation_id'";
    if ($connection->query($delete_sql) === TRUE) {
        header("Location: admin_Reservation.php");
        exit();
    } else {
        $message = "Error deleting reservation: " . $connection->error;
    }
}

// Fetch reservation data along with user info
$sql = "SELECT r.*, u.first_name, u.last_name, u.email 
        FROM reservations r
        INNER JOIN users u ON r.user_id = u.user_id
        WHERE r.reservation_id='$reservation_id'";

$result = $connection->query($sql);

if (!$result || $result->num_rows == 0) {
    die("Reservation not found.");
}

$reservation = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Reservation</title>
    <!-- Link to CSS -->
    <link rel="stylesheet" href="admin_edit_reservation.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'header.php'; ?>

<div class="edit-container">
    <h2>Edit Reservation</h2>

    <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>

    <!-- Display user info -->
    <div class="user-info">
        <p><strong>User:</strong> <?= htmlspecialchars($reservation['first_name'] . ' ' . $reservation['last_name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($reservation['email']) ?></p>
    </div>

    <form method="POST" class="edit-form">
        <label for="date">Date</label>
        <input type="date" id="date" name="date" value="<?= $reservation['date'] ?>" required>

        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" value="<?= $reservation['phone'] ?>" required>

        <label for="people">People</label>
        <input type="number" id="people" name="people" value="<?= $reservation['people'] ?>" required min="1">

        <label for="time">Time</label>
        <input type="time" id="time" name="time" value="<?= $reservation['time'] ?>" required>

        <div class="btn-group">
            <button type="submit" name="update" class="edit-btn">Update</button>
            <button type="submit" name="delete" class="delete-btn" onclick="return confirm('Are you sure you want to delete this reservation?')">Delete</button>
        </div>
    </form>

    <a href="admin_Reservation.php" class="back-btn">Back to Reservations</a>
</div>

</body>
</html>

