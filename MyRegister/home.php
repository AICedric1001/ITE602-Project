<?php
session_start();


// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user']);

if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    header("Location: index.php"); // Redirect to the login page after logout
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Reservation System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome to School!</h1>
        <nav>
            <?php if ($isLoggedIn): ?>
            <a href="reservation.php" id="reservation-btn">Make a Reservation</a>
            <a href="users_list.php" id="listuser-btn">Attendance List</a>
            <a href="?logout=false" id="logout-btn">Logout</a>
            <?php else: ?>
                <a href="index.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <script>
        function openReservationPage() {
            alert("Redirecting to Reservation Page...");
        }
    </script>
</body>
</html>

<?php if ($isLoggedIn): ?>
    <div class="container">
        <h1>Welcome to Our School!</h1>
        <div class="robot-container">
            <div class="reservation-button" onclick="openReservationPage()">
                📅
            </div>
            <p class="dialogue">Plan your academic activities with ease!</p>
        </div>
    </div>

    <div class="section animated">
        <h2>School Facilities</h2>
        <img src="images/classroom.jpg" alt="classroom">
        <img src="images/lab.jpg" alt="lab">
        <img src="images/library.jpg" alt="library">
    </div>

    <div class="section animated">
        <h2>School Reservations Offer...</h2>
        <ul>
            <li><h1>Classroom Reservations</h1></li>
            <li><h1>Laboratory Bookings</h1></li>
            <li><h1>Library Study Spaces</h1></li>
            <li><h1>Event Spaces</h1></li>
        </ul>
        <p>Efficiently manage and reserve school resources with our School Reservation System!</p>
    </div>

    <div class="search-container">
        🔍
        <input type="text" class="search-bar" placeholder="Search...">
    </div>

    <script>
        function openReservationPage() {
            alert("Redirecting to Reservation Page...");
        }
    </script>
</body>
</html>
  <?php endif; ?>