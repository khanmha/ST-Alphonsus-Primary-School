<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pupil and Parent Form</title>
    <link rel="stylesheet" href="stylepupil.css">
</head>
<body>
    <h1>Pupil and Parent Details</h1>

    <?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database 'st_alphonsus'
    $conn = new mysqli("localhost", "root", "", "st_alphonsus");

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } // Display error message if connection fails

    // retrieve form data
    $pupil_full_name = $conn->real_escape_string($_POST['pupil_fullname']);
    $medical_info = $conn->real_escape_string($_POST['medical_info']);
    $date_of_birth = $conn->real_escape_string($_POST['dob']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $pupil_email = $conn->real_escape_string($_POST['pupil_email']);
    $pupil_phone = $conn->real_escape_string($_POST['pupil_phone']);
    $parent_full_name = $conn->real_escape_string($_POST['parent_fullname']);
    $parent_email = $conn->real_escape_string($_POST['parent_email']);
    $address = $conn->real_escape_string($_POST['address']);
    $parent_phone = $conn->real_escape_string($_POST['parent_phone']);
    $class_name = $conn->real_escape_string($_POST['class_id']);

    // SQL query to get the class ID based on the class name
    // This is necessary to establish the relationship between pupil and class in the database
    $sql_class = "SELECT class_id FROM classes WHERE class_name = '$class_name'";
    $result_class = $conn->query($sql_class);

    // Check if the class exists in the database
    if ($result_class->num_rows > 0) {
        $row_class = $result_class->fetch_assoc();
        $class_id = $row_class['class_id'];
    } else {
        // If the class is not found, display an error 
        echo "<p>Error: Class not found in the database.</p>";
        exit();
    }

    // SQL query to insert pupil details into the database
    $sql_pupil = "INSERT INTO pupil (full_name, class_id, medical_info, date_of_birth, gender, email, phone) 
                  VALUES ('$pupil_full_name', '$class_id', '$medical_info', '$date_of_birth', '$gender', '$pupil_email', '$pupil_phone')";

    // Check if pupil insertion was successful
    if ($conn->query($sql_pupil) === TRUE) {
        echo "<p>Pupil submitted successfully!</p>";
        // Check for query success (check if the data has been inserted)
            // Show success message if inserted
        $pupil_id = $conn->insert_id;
    } else {
        // show error message if insertion fails
        echo "<p>Error inserting pupil: " . $conn->error . "</p>";
        exit();
    }

    // SQL query to insert parent details into the database
    $sql_parent = "INSERT INTO parents (full_name, email, address, phone)
                   VALUES ('$parent_full_name', '$parent_email', '$address', '$parent_phone')";

    // Check if parent insertion was successful
    if ($conn->query($sql_parent) === TRUE) {
        echo "<p>Parent submitted successfully!</p>";
        // Check for query success (check if the data has been inserted)
            // Show success message if inserted
        $parent_id = $conn->insert_id;
    } else {
        // show error message if insertion fails
        echo "<p>Error inserting parent: " . $conn->error . "</p>";
        exit();
    }

    // SQL query to insert into the relationship junction table between the parent and pupil 
    $sql_junction = "INSERT INTO parent_pupil (parent_id, pupil_id) VALUES ('$parent_id', '$pupil_id')";

    // Check if the parent-pupil relationship was successfully inserted
    if ($conn->query($sql_junction) === TRUE) {
        echo "<p>Parent-Pupil relationship added successfully!</p>";
    } else {
        // If there was an error inserting the parent-pupil relationship, display an error message
        echo "<p>Error inserting into parent_pupil: " . $conn->error . "</p>";
    }

    // Close the database connection
    $conn->close();
}
?>

    <form action="pupil.php" method="post">
        <h2>Pupil Details</h2>
        <label for="pupil_fullname">Full Name:</label><br>
        <input type="text" id="pupil_fullname" name="pupil_fullname" required><br><br>

        <label for="class_id">Pupil Class:</label><br>
        <select id="class_id" name="class_id" required>
        <option value="" disabled selected>Select</option>
            <option value="Reception">Reception</option>
            <option value="Year 1">Year 1</option>
            <option value="Year 2">Year 2</option>
            <option value="Year 3">Year 3</option>
            <option value="Year 4">Year 4</option>
            <option value="Year 5">Year 5</option>
            <option value="Year 6">Year 6</option>
        </select><br><br>

        <label for="medical_info">Medical Information:</label><br>
        <textarea id="medical_info" name="medical_info" rows="4" cols="50" required></textarea><br><br>

        <label for="dob">Date of Birth:</label><br>
        <input type="date" id="dob" name="dob" required><br><br>

        <label for="gender">Gender:</label><br>
        <select id="gender" name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select><br><br>

        <label for="pupil_email">Email:</label><br>
        <input type="email" id="pupil_email" name="pupil_email" required><br><br>

        <label for="pupil_phone">Phone Number:</label><br>
        <input type="tel" id="pupil_phone" name="pupil_phone" pattern="^\+44\d{10}$" placeholder="+44XXXXXXXXXX" required><br><br>

        <h2>Parent Details</h2>
        <label for="parent_fullname">Full Name:</label><br>
        <input type="text" id="parent_fullname" name="parent_fullname" required><br><br>

        <label for="parent_email">Email:</label><br>
        <input type="email" id="parent_email" name="parent_email" required><br><br>

        <label for="address">Address:</label><br>
        <textarea id="address" name="address" rows="4" cols="50" required></textarea><br><br>

        <label for="parent_phone">Phone Number:</label><br>
        <input type="tel" id="parent_phone" name="parent_phone" pattern="^\+44\d{10}$" placeholder="+44XXXXXXXXXX" required><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
