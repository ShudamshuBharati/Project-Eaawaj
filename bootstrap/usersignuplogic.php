<?php
// Database configuration
include 'dbconnect.php';

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Capture form data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashing password
    $address = $conn->real_escape_string($_POST['address']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $phone = $conn->real_escape_string($_POST['number']);

    // Insert query
    $sql = "INSERT INTO users (name, email, password, address, gender, dob, phone)
            VALUES ('$name', '$email', '$password', '$address', '$gender', '$dob', '$phone')";

    // Execute query with error handling
    if ($conn->query($sql) === TRUE) {
        // Success message and redirect to login page
        echo "<script>
                alert('User signup successful!');
                window.location.href = '/bootstrap/userlogin.php';
              </script>";
    } else {
        // Error message
        echo "<script>
                alert('Error: Could not register. Please try again.');
              </script>";
    }
}

// Close connection
$conn->close();
?>
