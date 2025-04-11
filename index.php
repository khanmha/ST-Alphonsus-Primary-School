<?php
// Start the session so we can use session variables
session_start();

// Check if the form was submitted 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve the role and password from the form submission
    $role = $_POST['role'];         // Role selected by the user (admin, teacher, or parent)
    $password = $_POST['password']; // Password entered by the user

    // Predefined passwords for each role (for simplicity)
    $credentials = [
        "admin" => "admin123",      // Admin role password
        "teacher" => "teacher123",  // Teacher role password
        "parent" => "parent123"     // Parent role password
    ];

    // Check if the role exists in the credentials array and if the password matches
    // If the role exists and the password matches, set the session variable
    if (isset($credentials[$role]) && $credentials[$role] === $password) {

        // If credentials are correct, save the role in session
        $_SESSION['role'] = $role;

        // Redirect user to home page
        header("Location: home.php");
        exit(); // Stop further script execution after redirect
    } else {
        // If login fails, show an error message
        $error = "Invalid role or password.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login - St Alphonsus</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!DOCTYPE html>
<html>
<head>
    <title>Login - St Alphonsus</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f8fb;
            color: #333;
        }

        h2 {
            color: #2a5d84;
            text-align: center;
            margin-top: 40px;
        }

        form {
            width: 300px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        label {
            font-size: 16px;
            color: #2a5d84;
            margin-bottom: 10px;
            display: block;
        }

        select, input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            margin-left: -10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #2a5d84;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: transform 0.3s ease;
        }

        button:hover {
            transform: scale(0.95);
        }

        p {
            color: red;
            font-size: 14px;
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
    </style>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <label for="role">Select Role:</label><br>
        <select name="role" id="role" required>
            <option value="admin">Admin</option>
            <option value="teacher">Teacher</option>
            <option value="parent">Parent</option>
        </select><br><br>

        <label for="password">Enter Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>