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

if ($_SESSION['role'] !== 'admin') {
    echo "<script>alert('Access Denied: Admins only'); window.location='menu.php';</script>";
    exit;
}

// Connect to database
$connection = new mysqli("localhost", "root", "", "db_basilico");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch all reservations with user info
$sql = "SELECT 
            reservations.reservation_id,
            users.first_name,
            users.last_name,
            users.email,
            reservations.date,
            reservations.phone,
            reservations.people,
            reservations.time
        FROM reservations
        INNER JOIN users 
            ON reservations.user_id = users.user_id
        ORDER BY reservations.time ASC";

$result = $connection->query($sql);
if (!$result) {
    die("Query failed: " . $connection->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Reservations</title>
    <link rel="stylesheet" href="admin_Reservation.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="admin-container">
    <h1>Reservation Management</h1>

    <table class="reservation-table">
        <thead>
            <tr>
                <th>Reservation ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Date</th>
                <th>Phone</th>
                <th>People</th>
                <th>Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['reservation_id']}</td>
                        <td>{$row['first_name']}</td>
                        <td>{$row['last_name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['date']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['people']}</td>
                        <td>{$row['time']}</td>
                        <td>
                            <a href='admin_edit_reservation.php?id={$row['reservation_id']}' class='edit-btn'>Edit</a>
                            <a href='admin_Reservation.php?delete_id={$row['id']}' onclick=\"return confirm('Delete this reservation?')\">
                                <img src='images/delete.png' class='action-icon'>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No reservations found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <a href="../logout.php" class="logout-btn">Logout</a>
</div>

</body>
</html>
