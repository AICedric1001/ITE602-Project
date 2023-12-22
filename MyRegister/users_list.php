 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 800px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Attendance List</h2>


 <?php
        include_once("config.php");

        $users = array();

        // Fetch faculty members
        $facultyResult = $conn->query("SELECT * FROM Faculty");
        while ($row = $facultyResult->fetch_assoc()) {
            $users[] = array(
                'UserID' => $row['FacultyID'],
                'Firstname' => $row['Firstname'],
                'Lastname' => $row['Lastname'],
                'Role' => 'Faculty'
            );
        }

        // Fetch students
        $studentResult = $conn->query("SELECT * FROM Student");
        while ($row = $studentResult->fetch_assoc()) {
            $users[] = array(
                'UserID' => $row['StudentID'],
                'Firstname' => $row['Firstname'],
                'Lastname' => $row['Lastname'],
                'Role' => 'Student'
            );
        }

        // Fetch visitors
        $visitorResult = $conn->query("SELECT * FROM VisitorDetail");
        while ($row = $visitorResult->fetch_assoc()) {
            $users[] = array(
                'UserID' => $row['VisitorID'],
                'Firstname' => $row['Firstname'],
                'Lastname' => $row['Lastname'],
                'Role' => 'Visitor'
            );
        }

        // Fetch utility staff
        $utilityResult = $conn->query("SELECT * FROM UtilityDetail");
        while ($row = $utilityResult->fetch_assoc()) {
            $users[] = array(
                'UserID' => $row['UtilityID'],
                'Firstname' => $row['Firstname'],
                'Lastname' => $row['Lastname'],
                'Role' => 'Utility'
            );
        }

        $conn->close();

        // Display the users in a table
        if (!empty($users)) {
            echo "<table>";
            echo "<tr><th>User ID</th><th>Firstname</th><th>Lastname</th><th>Role</th></tr>";
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>{$user['UserID']}</td>";
                echo "<td>{$user['Firstname']}</td>";
                echo "<td>{$user['Lastname']}</td>";
                echo "<td>{$user['Role']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No users found.</p>";
        }
        ?>

    </div>
</body>
</html>