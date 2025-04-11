<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Form</title>
    <link rel="stylesheet" href="styleteacher.css">
</head>
<body>
    <h1>Teacher Details</h1>
    <?php
    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Connect to the database 'st_alphonsus'
        $conn = new mysqli("localhost", "root", "", "st_alphonsus");
        // Check if the connection was successful
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error); // Display error message if connection fails
        }
        // Retrieve form data
        $fullname = $conn->real_escape_string($_POST['teacher_fullname']);
        $gender = $conn->real_escape_string($_POST['gender']);
        $teacher_class = $conn->real_escape_string($_POST['class_name']);
        $date_of_birth = $conn->real_escape_string($_POST['dob']);
        $email = $conn->real_escape_string($_POST['teacher_email']);
        $phone_number = $conn->real_escape_string($_POST['teacher_phone']);
        $address = $conn->real_escape_string($_POST['address']);
        $salary = $conn->real_escape_string($_POST['salary']);
        $background_check = $conn->real_escape_string($_POST['background_check']);

        // Insert the data into the teacher table in the database
        $sql = "INSERT INTO teacher (fullname, gender, teacher_class, date_of_birth, email, phone_number, address, annual_salary, background_check) 
                VALUES ('$fullname', '$gender', '$teacher_class ', '$date_of_birth', '$email', '$phone_number', '$address', '$salary', '$background_check')";

        // Execute the query and check for success
        if ($conn->query($sql) === TRUE) {
            echo "<p>Teacher details submitted successfully!</p>"; // Check for query success (check if the data has been inserted)
            // Show success message if inserted
        } else {
            echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>"; // Show error message if insertion fails
        }

        // Close the database connection
        $conn->close();
    }
    ?>

    <form action="teacher.php" method="post">
        <label for="teacher_fullname">Full Name:</label><br>
        <input type="text" id="teacher_fullname" name="teacher_fullname" required><br><br>

        <label for="class_name">Teacher Class:</label><br>
        <select id="class_name" name="class_name" required>
            <option value="" disabled selected>Select</option>
            <option value="Reception">Reception</option>
            <option value="Year 1">Year 1</option>
            <option value="Year 2">Year 2</option>
            <option value="Year 3">Year 3</option>
            <option value="Year 4">Year 4</option>
            <option value="Year 5">Year 5</option>
            <option value="Year 6">Year 6</option>
        </select><br><br>

        <label for="dob">Date of Birth:</label><br>
        <input type="date" id="dob" name="dob" required><br><br>

        <label for="gender">Gender:</label><br>
        <select id="gender" name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select><br><br>

        <label for="teacher_email">Email:</label><br>
        <input type="email" id="teacher_email" name="teacher_email" required><br><br>

        <label for="teacher_phone">Phone Number:</label><br>
        <input type="tel" id="teacher_phone" name="teacher_phone" pattern="^\+44\d{10}$" placeholder="+44XXXXXXXXX" required><br><br>

        <label for="address">Address:</label><br>
        <textarea id="address" name="address" rows="4" cols="50" required></textarea><br><br>

        <label for="background_check">Background Check:</label><br>
        <select id="background_check" name="background_check" required>
            <option value="" disabled selected>Select</option>
            <option value="Pass">Pass</option>
            <option value="Fail">Fail</option>
        </select><br><br>

        <label for="salary">Salary (£):</label><br>
        <input type="number" id="salary" name="salary" min="0" step="0.01" required><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
