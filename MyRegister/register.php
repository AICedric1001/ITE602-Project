<?php
include_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = $_POST["role"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];

    $stmt = null;

    switch ($role) {
        case 'student':
            $idField = "course_id";
            break;

        case 'faculty':
            $idField = "department_id";
            break;

        case 'utility':
            $idField = "Location";
            break;

        case 'visitor':
            $idField = "visit_date";
            break;

        default:
            // Handle invalid role
            echo "<p>Error: Invalid role.</p>";
            exit();
    }

    $stmt = $conn->prepare("INSERT INTO $role (Firstname, Lastname, $idField) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $firstname, $lastname, $_POST[$idField]);

    if ($stmt->execute()) {
        $stmt_user = $conn->prepare("INSERT INTO User (username, password, role) VALUES (?, ?, ?)");
        $stmt_user->bind_param("sss", $username, $password, $role);

        if ($stmt_user->execute()) {
            echo "<p class='success-message'>Registration successful. <a href='index.php'>Login here</a>.</p>";
        } else {
            echo "<p class='error-message'>Error during user registration.</p>";
        }

        $stmt_user->close();
    } else {
        echo "<p class='error-message'>Error during registration.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Registration</h2>

        <form method="post" action="register.php">
            <label for="username">Username:</label>
            <input type="text" name="username" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" required><br>

            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="student">Student</option>
                <option value="faculty">Faculty</option>
                <option value="utility">Utility</option>
                <option value="visitor">Visitor</option>
            </select><br>

            <label for="firstname">First Name:</label>
            <input type="text" name="firstname" required><br>

            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname" required><br>

            <div id="student-fields" class="role-fields" style="display: none;">
                <label for="course_id">Course ID:</label>
                <input type="text" name="course_id">
            </div>

            <div id="faculty-fields" class="role-fields" style="display: none;">
                <label for="department_id">Department ID:</label>
                <input type="text" name="department_id">
            </div>

            <div id="utility-fields" class="role-fields" style="display: none;">
                <label for="location">Location:</label>
                <input type="text" name="location">
            </div>

            <div id="visitor-fields" class="role-fields" style="display: none;">
                <label for="visit_date">Visit Date:</label>
                <input type="text" name="visit_date">
            </div>

            <input type="submit" value="Register">
        </form>

        <script>
            function updateRoleFields() {
                var selectedRole = document.getElementById('role').value;
                var roleFields = document.querySelectorAll('.role-fields');

                roleFields.forEach(function (field) {
                    field.style.display = 'none';
                });

                document.getElementById(selectedRole + '-fields').style.display = 'block';
            }

            window.addEventListener('load', updateRoleFields);
            document.getElementById('role').addEventListener('change', updateRoleFields);
        </script>
    </div>
</body>
</html>
