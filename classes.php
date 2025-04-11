<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Form</title>
    <link rel="stylesheet" href="styleclasses.css">
</head>
<body>
    <h1>Class Details</h1>
    <?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish a connection to the database 'st_alphonsus'
    $conn = new mysqli("localhost", "root", "", "st_alphonsus");

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error); // Display error message if connection fails
    }

    // retrieve form data
    $class_name = $conn->real_escape_string($_POST['class_name']);
    $class_capacity = $conn->real_escape_string($_POST['class_capacity']);
    $teacher_id = $conn->real_escape_string($_POST['teacher_id']);

    // First, check if the class already exists in the database
    $sql_check_class = "SELECT class_id FROM classes WHERE class_name = '$class_name'";
    $result_check_class = $conn->query($sql_check_class);

    // If the class exists, check the number of pupils already in the class
    if ($result_check_class->num_rows > 0) {
        // Fetch the class_id of the existing class
        $row = $result_check_class->fetch_assoc();
        $class_id = $row['class_id'];

        // Query to count how many pupils are currently enrolled in this class
        $sql_check_capacity = "SELECT COUNT(*) AS current_students FROM pupil WHERE class_id = '$class_id'";
        $result_check = $conn->query($sql_check_capacity);
        $row = $result_check->fetch_assoc();
        $current_students = $row['current_students'];

        // Check if the class is already full
        if ($current_students >= $class_capacity) {
            // If the class is full, show a message and prevent further enrollment
            echo "<p>You cannot add more pupils to this class because it is already full.</p>";
        } else {
            // If the class is not full, display a message indicating space is available
            echo "<p>This class already exists, and there's space for more pupils.</p>";
        }
    } else {
        // If the class doesn't exist, create a new class entry
        $sql_insert = "INSERT INTO classes (class_name, class_capacity, teacher_id) 
                       VALUES ('$class_name', '$class_capacity', '$teacher_id')";

        // Execute the query to insert the new class
        if ($conn->query($sql_insert) === TRUE) {
            echo "<p>Class created successfully!</p>";
        } else {
            // If there's an error during insertion, display the error message
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }
    // Close the database connection 
    $conn->close();
}
?>

    <form action="classes.php" method="post">
        <label for="class_name">Class Name:</label><br>
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

        <label for="class_capacity">Class Capacity:</label><br>
        <input type="number" id="class_capacity" name="class_capacity" min="1" max="20" required><br><br>

        <label for="teacher_id">Teacher:</label><br>
        <select id="teacher_id" name="teacher_id" required>
            <option value="" disabled selected>Select Teacher</option>
            <?php
            $conn = new mysqli("localhost", "root", "", "st_alphonsus");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT teacher_id, fullname FROM teacher";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['teacher_id'] . "'>" . $row['fullname'] . "</option>";
            }

            $conn->close();
            ?>
        </select><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
