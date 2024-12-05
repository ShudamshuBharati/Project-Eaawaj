<?php
// Placeholder for user signup functionality
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Signup - E-AAWAJ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container py-5">
    <h2 class="text-center mb-4">User Signup</h2>
    <form method="POST" action="usersignuplogic.php">
        <!-- Name -->
        <div class="mb-3">
            <label for="user-name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="user-name" name="name" required>
        </div>
        <!-- Email -->
        <div class="mb-3">
            <label for="user-email" class="form-label">Email</label>
            <input type="email" class="form-control" id="user-email" name="email" required>
        </div>
        <!-- Password -->
        <div class="mb-3">
            <label for="user-password" class="form-label">Password</label>
            <input type="password" class="form-control" id="user-password" name="password" required>
        </div>
        <!-- Address -->
        <div class="mb-3">
            <label for="user-address" class="form-label">Address</label>
            <input type="text" class="form-control" id="user-address" name="address" required>
        </div>
        <!-- Gender -->
        <div class="mb-3">
            <label class="form-label">Gender</label>
            <select class="form-select" name="gender" required>
                <option value="" disabled selected>Select your gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <!-- Date of Birth -->
        <div class="mb-3">
            <label for="user-dob" class="form-label">Date of Birth</label>
            <input type="date" class="form-control" id="user-dob" name="dob" required>
        </div>
        <!-- Phone Number -->
        <div class="mb-3">
            <label for="user-phone" class="form-label">Phone Number</label>
            <input type="tel" class="form-control" id="user-phone" name="number" required>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100">Sign Up</button>
    </form>

    <div class="text-center mt-3">
        Already have an account? <a href="/bootstrap/userlogin.php">Login here!</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
