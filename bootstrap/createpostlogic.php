<?php
session_start(); // Start the session

// Check if the user is logged in and has a name stored in the session
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest'; // Default to 'Guest' if not logged in

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the message from the form input
    $message = $_POST['message'];

    // Connect to the database
    include('dbconnect.php');

    // Insert the message into the database
    $stmt = $conn->prepare("INSERT INTO post (name, message, status) VALUES (?, ?, ?)");
    $status = 'active'; // Default status
    $stmt->bind_param("sss", $user_name, $message, $status);

    if ($stmt->execute()) {
        // Success: Send alert message
        echo "<script>alert('Post created successfully.'); window.location.href='index.php';</script>";
    } else {
        // Error: Handle error
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>
