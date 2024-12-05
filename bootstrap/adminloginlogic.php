<?php
session_start();

// Hardcoded admin credentials (replace with database check for real application)
$admin_username = "surya";  // Replace with a real username
$admin_password = "asdfasdf";  // Replace with a real password (hashed in real-world cases)

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the entered username and password
    $entered_username = $_POST['username'];
    $entered_password = $_POST['password'];

    // Validate credentials
    if ($entered_username === $admin_username && $entered_password === $admin_password) {
        // If successful, set session variable and redirect to dashboard
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        // If login fails, set error message
        $error_message = "Invalid username or password. Please try again.";
    }
}
?>
