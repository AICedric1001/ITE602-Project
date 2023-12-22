<?php
session_start();

include_once("config.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dormitoryNumber = $_POST["dormitoryNumber"];
    $checkInDate = $_POST["checkInDate"];
    $checkOutDate = $_POST["checkOutDate"];
    $userID = $_POST["userID"];
    $studentID = $_POST["studentID"];

    // Check if the dormitory number already exists
    $checkStmt = $conn->prepare("SELECT DormitoryNumber FROM Reservation WHERE DormitoryNumber = ?");
    $checkStmt->bind_param("i", $dormitoryNumber);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "Dormitory number already taken. Please choose a different one.";
    } else {
        // Check if the provided UserID exists and corresponds to a student
        $userCheckStmt = $conn->prepare("SELECT UserID FROM User WHERE UserID = ? AND role = 'student'");
        $userCheckStmt->bind_param("i", $userID);
        $userCheckStmt->execute();
        $userCheckStmt->store_result();

        if ($userCheckStmt->num_rows > 0) {
            // Check if the provided StudentID exists and is unique
            $studentCheckStmt = $conn->prepare("SELECT StudentID FROM Student WHERE StudentID = ?");
            $studentCheckStmt->bind_param("i", $studentID);
            $studentCheckStmt->execute();
            $studentCheckStmt->store_result();

            if ($studentCheckStmt->num_rows > 0) {
                // Perform database insertion here using the provided values
                $insertStmt = $conn->prepare("INSERT INTO Reservation (DormitoryNumber, CheckInDate, CheckOutDate, UserID, StudentID) VALUES (?, ?, ?, ?, ?)");
                $insertStmt->bind_param("issii", $dormitoryNumber, $checkInDate, $checkOutDate, $userID, $studentID);

                if ($insertStmt->execute()) {
                    // Store reservation details in session
                    $_SESSION['reservation_details'] = [
                        'DormitoryNumber' => $dormitoryNumber,
                        'CheckInDate' => $checkInDate,
                        'CheckOutDate' => $checkOutDate,
                        'UserID' => $userID,
                        'StudentID' => $studentID
                    ];

                    header("Location: reservation_details.php");
                    exit();
                } else {
                    echo "Error during reservation: " . $insertStmt->error;
                }

                $insertStmt->close();
            } else {
                echo "Invalid Student ID. Please provide a valid and unique Student ID.";
            }

            $studentCheckStmt->close();
        } else {
            echo "Invalid User ID. Please provide a valid and unique User ID with the role of a student.";
        }

        $userCheckStmt->close();
    }

    $checkStmt->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Form</title>
    <link rel="stylesheet" href="styles.css">
    <style>
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

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 20px 0 10px; /* Increased margin */
            color: #333;
        }

        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px; /* Increased margin-bottom */
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        select {
            cursor: pointer;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
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
        <h2>Reservation Form</h2>

        <form method="post" action="">
            <label for="dormitoryNumber">Dormitory Number:</label>
            <input type="number" name="dormitoryNumber" required>

            <label for="checkInDate">Check-In Date:</label>
            <input type="date" name="checkInDate" required>

            <label for="checkOutDate">Check-Out Date:</label>
            <input type="date" name="checkOutDate" required>

            <label for="userID">User ID:</label>
            <input type="number" name="userID" required>

            <label for="studentID">Student ID:</label>
            <input type="number" name="studentID" required>

            <input type="submit" value="Make Reservation">
        </form>
    </div>
</body>
</html>
