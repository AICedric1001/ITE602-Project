<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Details</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        p {
            margin-bottom: 10px;
        }
    </style>
</head>
<header>
        <h1>Welcome to School!</h1>
        <nav>
            <a href="home.php">Home</a>
        </nav>
    </header>
<body>
    <div class="container">
        <?php
        session_start();

        // Check if reservation details are set in the session
        if (isset($_SESSION['reservation_details'])) {
            $reservationDetails = $_SESSION['reservation_details'];
            // Unset the session variable to clear the data after displaying
            unset($_SESSION['reservation_details']);

            // Display the reservation details
            echo "<h2>Reservation Details</h2>";
            echo "<p>Dormitory Number: " . $reservationDetails['DormitoryNumber'] . "</p>";
            echo "<p>Check-In Date: " . $reservationDetails['CheckInDate'] . "</p>";
            echo "<p>Check-Out Date: " . $reservationDetails['CheckOutDate'] . "</p>";
            echo "<p>User ID: " . $reservationDetails['UserID'] . "</p>";
            echo "<p>Student ID: " . $reservationDetails['StudentID'] . "</p>";
            echo "<h2>Thank you!</h2>";

        } else {
            // If session variable is not set, redirect to the reservation form
            header("Location: reservation_form.php");
            exit();
        }
        ?>
    </div>
</body>
</html>
