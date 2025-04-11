<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Classes</title>
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
session_start(); // Start the session to access user data
// Check if the user is logged in
if (!isset($_SESSION['role'])) {
    header("Location: login.php"); // Redirect to login page (index.php) if not logged in
    exit();
}

// Check if the user has the correct role (admin or parent) to access this page
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'parent') {
    echo "Access denied."; // Show access denied message if the user doesn't have the correct role
    exit();
}

// Connect to the database 'st_alphonsus'
$conn = new mysqli("localhost", "root", "", "st_alphonsus");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Display error message if connection fails
}

// Handle deletion of class
// Check if the form is submitted to delete a class
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) { // retrieve the class id from the form submission
    $class_id = $conn->real_escape_string($_POST['class_id']); 
    // Delete the class from the database
    $conn->query("DELETE FROM classes WHERE class_id = '$class_id'");
    echo "<p style='color:red;'>Class deleted successfully.</p>"; // Display confirmation message after deletion
}

// Query to fetch class details along with the teacher's name
$sql = "SELECT c.class_id, c.class_name, c.class_capacity, t.fullname AS teacher_name 
        FROM classes c
        INNER JOIN teacher t ON c.teacher_id = t.teacher_id";

$result = $conn->query($sql); // Execute the query and store the result

// Check if there are any results for the class details
if ($result->num_rows > 0) {
    echo "<h2>Class Details</h2>"; // Display the heading for the table
    echo "<table>
            <tr>
                <th>Class ID</th>
                <th>Class Name</th>
                <th>Class Capacity</th>
                <th>Teacher</th>
                <th>Action</th>
            </tr>";
    
    // Loop through each row and display class details
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['class_id']}</td>
                <td>{$row['class_name']}</td>
                <td>{$row['class_capacity']}</td>
                <td>{$row['teacher_name']}</td>
                <td>
                    <form method='POST' onsubmit='return confirm(\"Are you sure you want to delete this class?\")'>
                        <input type='hidden' name='class_id' value='{$row['class_id']}'>
                        <button type='submit' name='delete' class='delete-btn'>Delete</button>
                    </form>
                </td>
            </tr>";
    }

    echo "</table>"; // Close the table after displaying all rows
} else {
    echo "<p>No classes found in the database.</p>"; // Display message if no classes are found
}

// Close the database connection
$conn->close();
?>
</body>
</html>
