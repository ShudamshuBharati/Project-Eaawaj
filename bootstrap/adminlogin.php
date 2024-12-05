<?php
session_start();

// Define the correct credentials
$correct_username = "surya";
$correct_password = "asdfasdf";

// Initialize error message
$error_message = "";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the entered username and password
    $entered_username = $_POST['username'];
    $entered_password = $_POST['password'];

    // Validate credentials
    if ($entered_username === $correct_username && $entered_password === $correct_password) {
        // If successful, set session variable and redirect to dashboard
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        // If login fails, set error message
        $error_message = "Incorrect credentials. Please try again.";
    }
}
?>

<!-- If there's an error, include the message in the HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - E-AAWAJ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container py-5">
    <h2 class="text-center mb-4">Admin Login</h2>
    
    <!-- Show error message if login fails -->
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="adminloginlogic.php">
        <div class="mb-3">
            <label for="admin-username" class="form-label">Admin Username</label>
            <input type="text" class="form-control" id="admin-username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="admin-password" class="form-label">Password</label>
            <input type="password" class="form-control" id="admin-password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
