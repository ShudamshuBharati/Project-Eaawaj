<?php
// Placeholder for user login functionality
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login - E-AAWAJ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container py-5">
    <h2 class="text-center mb-4">User Login</h2>
    <form method="POST" action="userloginlogic.php">
        <div class="mb-3">
            <label for="user-username" class="form-label">Username</label>
            <input type="text" class="form-control" id="user-username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="user-password" class="form-label">Password</label>
            <input type="password" class="form-control" id="user-password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>

    <div>Don't have a account?<a href="/bootstrap/usersignup.php">Sign Up!</a></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
