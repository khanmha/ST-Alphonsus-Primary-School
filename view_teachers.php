<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Teachers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f4f8fb;
            color: #333;
        }

        h2 {
            color: #2a5d84;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #888;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f3f3f3;
            color: #2a5d84;
        }

        td {
            color: #333;
        }

        .delete-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: transform 0.2s ease-in-out;
        }

        .delete-btn:hover {
            transform: scale(0.95);
        }

        footer {
            background-color: #2a5d84;
            color: white;
            padding: 20px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        footer a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 16px;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<?php
session_start(); // Starts the session 
// Check if user is logged in and has a valid role
// If not logged in, redirect to login page
if (!isset($_SESSION['role'])) {
    header("Location: index.php"); // Redirect to login (index.php) page 
    exit();
}

// Check if the user has either 'teacher' or 'admin' role to access this page 
if ($_SESSION['role'] !== 'teacher' && $_SESSION['role'] !== 'admin') {
    echo "Access Denied."; // Display a message if the user does not have the proper role
    exit();
}

// Database connection to the 'st_alphonsus' database
$conn = new mysqli("localhost", "root", "", "st_alphonsus");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Display error message if connection fails
}

// deleting teacher functionality
// Check if the form was submitted for deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    // Retrieve the teacher ID to be deleted from the form
    $teacher_id = $conn->real_escape_string($_POST['teacher_id']);
    
    // Execute the DELETE query to remove the teacher from the database
    $conn->query("DELETE FROM teacher WHERE teacher_id = '$teacher_id'");
    
    // Display a confirmation message
    echo "<p style='color:red;'>Teacher deleted successfully.</p>";
}

// Query to retrieve all teacher details from the database
$sql = "SELECT teacher_id, fullname, teacher_class, date_of_birth, gender, email, phone_number, address, annual_salary, background_check 
        FROM teacher";

// Execute the query and store the result
$result = $conn->query($sql);

// Check if there are any teachers in the database
if ($result->num_rows > 0) {
    // Display the header for the teacher details table
    echo "<h2>Teacher Details</h2>";
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Class</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Salary (£)</th>
                <th>Background Check</th>
                <th>Action</th>
            </tr>";
            // Loop through each row of data and display it in a table
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['teacher_id']}</td>
                <td>{$row['fullname']}</td>
                <td>{$row['teacher_class']}</td>
                <td>{$row['date_of_birth']}</td>
                <td>{$row['gender']}</td>
                <td>{$row['email']}</td>
                <td>{$row['phone_number']}</td>
                <td>{$row['address']}</td>
                <td>{$row['annual_salary']}</td>
                <td>{$row['background_check']}</td>
                <td>
                    <form method='POST' onsubmit='return confirm(\"Are you sure you want to delete this teacher?\")'>
                        <input type='hidden' name='teacher_id' value='{$row['teacher_id']}'>
                        <button type='submit' name='delete' class='delete-btn'>Delete</button>
                    </form>
                </td>
            </tr>";
    }

    echo "</table>"; // Close the table tag
} else {
    echo "<p>No teachers found in the database.</p>"; // If no teachers are found, display a message
}

// Close the database connection
$conn->close();
?>
</body>
</html>
