<?php
// Include the database connection file
include 'dbconnect.php';

// Start session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Capture form data
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password']; // Plain text password from the form

    // Query to fetch the user record based on username
    $sql = "SELECT * FROM users WHERE email = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the user record
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            // Set a cookie (optional)
            setcookie("user_name", $user['name'], time() + (86400 * 30), "/"); // 30 days

            // Redirect to homepage
            echo "<script>
                    alert('Login successful!');
                    window.location.href = '/bootstrap/index.php'; // Redirect to homepage
                  </script>";
        } else {
            // Invalid password
            echo "<script>
                    alert('Invalid password. Please try again.');
                    window.history.back();
                  </script>";
        }
    } else {
        // Invalid username/email
        echo "<script>
                alert('No user found with the provided email. Please sign up first.');
                window.history.back();
              </script>";
    }
}

// Close database connection
$conn->close();
?>
