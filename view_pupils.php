<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Pupil and Parent Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f4f8fb;
            color: #333;
        }

        h1 {
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
<h1>Pupil and Parent Details</h1>

<?php
session_start(); // Start session
// Check if the user is logged in and has a valid role
// If not logged in, redirect to login page
if (!isset($_SESSION['role'])) {
    header("Location: login.php"); // Redirect to login (index.php) page 
    exit();
}
// Check if the user has 'admin' or 'parent' role to access the page
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'parent') {
    echo "Access denied."; // Display a message if the user does not have the proper role
    exit();
}

// Database connection to the 'st_alphonsus' database
$conn = new mysqli("localhost", "root", "", "st_alphonsus");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Display error message if connection fails
}

// deletion of pupil and parent relationship functionality
// Check if the form is submitted for deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    // Retrieve pupil ID from the form to be deleted
    $pupil_id = $conn->real_escape_string($_POST['pupil_id']);
    
    // Delete the relationship between pupil and parent, deleting from the parent_pupil table
    $conn->query("DELETE FROM parent_pupil WHERE pupil_id = '$pupil_id'");
    // Then delete the pupil from the pupil table
    $conn->query("DELETE FROM pupil WHERE pupil_id = '$pupil_id'");

    echo "<p style='color:red;'>Pupil and parent relationship deleted.</p>"; // Confirmation message
}

// Query to retrieve pupil and parent data by joining tables
$sql = "SELECT 
            pupil.pupil_id,
            pupil.full_name AS pupil_name,
            pupil.gender,
            pupil.date_of_birth,
            pupil.email AS pupil_email,
            pupil.phone AS pupil_phone,
            pupil.medical_info,
            classes.class_name,
            parents.full_name AS parent_name,
            parents.email AS parent_email,
            parents.phone AS parent_phone,
            parents.address
        FROM pupil
        JOIN classes ON pupil.class_id = classes.class_id
        JOIN parent_pupil ON pupil.pupil_id = parent_pupil.pupil_id
        JOIN parents ON parent_pupil.parent_id = parents.parent_id";


// Execute the query and store the result
$result = $conn->query($sql);

// Check if there are any pupil-parent relationships in the database
if ($result->num_rows > 0) {
    // Display the header of the table
    echo "<table>";
    echo "<tr>
            <th>Pupil ID</th>
            <th>Pupil Name</th>
            <th>Gender</th>
            <th>Date of Birth</th>
            <th>Pupil Email</th>
            <th>Pupil Phone</th>
            <th>Medical Info</th>
            <th>Class</th>
            <th>Parent Name</th>
            <th>Parent Email</th>
            <th>Parent Phone</th>
            <th>Address</th>
            <th>Action</th>
          </tr>";

    // Loop through each row of data and display it in a table
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['pupil_id']}</td>
                <td>{$row['pupil_name']}</td>
                <td>{$row['gender']}</td>
                <td>{$row['date_of_birth']}</td>
                <td>{$row['pupil_email']}</td>
                <td>{$row['pupil_phone']}</td>
                <td>{$row['medical_info']}</td>
                <td>{$row['class_name']}</td>
                <td>{$row['parent_name']}</td>
                <td>{$row['parent_email']}</td>
                <td>{$row['parent_phone']}</td>
                <td>{$row['address']}</td>
                <td>
                    <form method='POST' onsubmit='return confirm(\"Are you sure?\")'>
                        <input type='hidden' name='pupil_id' value='{$row['pupil_id']}'>
                        <button type='submit' name='delete' class='delete-btn'>Delete</button>
                    </form>
                </td>
              </tr>";
    }

    echo "</table>"; // Close the table tag
} else {
    echo "<p>No pupil-parent data found.</p>"; // Message if no data is found
}

// Close the database connection
$conn->close();
?>

</body>
</html>
