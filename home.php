<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>St Alphonsus Primary School</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
// Start a session 
session_start();

// Check if the user has a role assigned (i.e., logged in)
// This is to ensure that only logged-in users can access this page
// If the user is not logged in, redirect them to the login page (index.php)
if (!isset($_SESSION['role'])) {
    header("Location: index.php"); 
    exit(); 
}

// Get the user's role from the session
// This role will determine what content is displayed on the page
$role = $_SESSION['role'];
?>

<!-- Header with site title -->
<header>
    <div class="logo">
        <h1>St Alphonsus Primary School</h1>
    </div>

    <!-- Navigation menu (links shown based on user role) -->
    <nav>
        <ul>
            <!-- Show Teacher Details only if user is admin or teacher -->
            <?php if ($role === 'admin' || $role === 'teacher') : ?>
                <li><a href="./view_teachers.php" class="add-btn" style="text-decoration: none;">Teacher Details</a></li>
            <?php endif; ?>

            <!-- Show Pupil Details only if user is admin or parent -->
            <?php if ($role === 'admin' || $role === 'parent') : ?>
                <li><a href="./view_pupils.php" class="add-btn" style="text-decoration: none;">Pupil Details</a></li>
            <?php endif; ?>

            <!-- Show Classes Details only if user is admin -->
            <?php if ($role === 'admin') : ?>
                <li><a href="./view_classes.php" class="add-btn" style="text-decoration: none;">Classes Details</a></li>
            <?php endif; ?>

            <!-- Logout option for all logged-in users -->
            <li><a href="logout.php" class="add-btn" style="text-decoration: none;">Logout</a></li>
        </ul>
    </nav>
</header>


<section class="main-content">
    <h2>Welcome to St Alphonsus Primary School!</h2>
    <p class="motto">"Nurturing young minds for a brighter tomorrow."</p>

   
    <div class="image-container">
        <div class="image">
            <img src="istockphoto-1340516764-1024x1024.jpg" alt="Image 1">
        </div>
        <div class="image">
            <img src="istockphoto-1346503881-1024x1024.jpg" alt="Image 2">
        </div>
    </div>

   
    <div class="buttons">
        <!-- Show Add buttons only if user is admin -->
        <!-- These buttons allow the admin to add new pupils, classes, or teachers to the system -->
        <?php if ($role === 'admin') : ?>
            <a href="./pupil.php" class="add-btn" style="text-decoration: none;">Add Pupil</a>
            <a href="./classes.php" class="add-btn" style="text-decoration: none;">Add Classes</a>
            <a href="./teacher.php" class="add-btn" style="text-decoration: none;">Add Teacher</a>
        <?php endif; ?>
    </div>
</section>


<br><br>
<footer>
    <p><a href="about_us.php">About Us</a></p> 

    <div class="social-media">
        <a href="https://www.facebook.com/" target="_blank">Facebook</a>
        <a href="https://www.instagram.com/" target="_blank">Instagram</a>
        <a href="https://wa.me/44123456789" target="_blank">WhatsApp</a> 
        <p>Phone: +44 123 456 789</p>
    </div>
</footer>

</body>
</html>
