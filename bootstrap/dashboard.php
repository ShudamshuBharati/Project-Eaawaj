<?php
session_start();

// Check if the admin is logged in, if not, redirect to the login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: adminlogin.php");
    exit;
}

// Include database connection
include('dbconnect.php');

// Fetch users from the database
$sql = "SELECT id, name, email, address, gender, dob, phone, status FROM users";
$result = $conn->query($sql);

// Fetch posts from the database
$post_sql = "SELECT id, name, message, status FROM post ORDER BY date DESC"; 
$post_result = $conn->query($post_sql);

// Check if users exist
$users = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    $users = [];
}

// Handle Block, Unblock, or Delete actions for users
if (isset($_GET['action']) && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $action = $_GET['action'];

    if ($action == 'block') {
        // Block user
        $sql = "UPDATE users SET status='blocked' WHERE id=$user_id";
        if ($conn->query($sql) === TRUE) {
            header("Location: dashboard.php?tab=" . (isset($_GET['tab']) ? $_GET['tab'] : 'pills-users')); // Stay on current tab
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    } elseif ($action == 'unblock') {
        // Unblock user
        $sql = "UPDATE users SET status='active' WHERE id=$user_id";
        if ($conn->query($sql) === TRUE) {
            header("Location: dashboard.php?tab=" . (isset($_GET['tab']) ? $_GET['tab'] : 'pills-users')); // Stay on current tab
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    } elseif ($action == 'delete') {
        // Delete user
        $sql = "DELETE FROM users WHERE id=$user_id";
        if ($conn->query($sql) === TRUE) {
            header("Location: dashboard.php?tab=" . (isset($_GET['tab']) ? $_GET['tab'] : 'pills-users')); // Stay on current tab
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Handle Delete Post action
if (isset($_GET['delete_post_id'])) {
    $post_id = $_GET['delete_post_id'];
    $sql = "DELETE FROM post WHERE id=$post_id";
    if ($conn->query($sql) === TRUE) {
        $tab = isset($_GET['tab']) ? $_GET['tab'] : 'pills-users'; // Default to users tab if no tab is set
        header("Location: dashboard.php?tab=$tab"); // Stay on the current tab
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - E-AAWAJ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container py-5">
    <h2 class="text-center mb-4">Admin Dashboard</h2>
    
    <!-- Navigation Tabs -->
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link <?php echo (isset($_GET['tab']) && $_GET['tab'] == 'pills-users') || !isset($_GET['tab']) ? 'active' : ''; ?>" id="pills-users-tab" data-bs-toggle="pill" href="#pills-users" role="tab" aria-controls="pills-users" aria-selected="true">Users</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?php echo isset($_GET['tab']) && $_GET['tab'] == 'pills-posts' ? 'active' : ''; ?>" id="pills-posts-tab" data-bs-toggle="pill" href="#pills-posts" role="tab" aria-controls="pills-posts" aria-selected="false">Posts</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="pills-tabContent">
        <!-- Users Tab -->
        <div class="tab-pane fade show <?php echo (isset($_GET['tab']) && $_GET['tab'] == 'pills-users') || !isset($_GET['tab']) ? 'active' : ''; ?>" id="pills-users" role="tabpanel" aria-labelledby="pills-users-tab">
            <h4>Users List</h4>
            <!-- Users Table -->
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Address</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Date of Birth</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($users) > 0): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <th scope="row"><?php echo $user['id']; ?></th>
                                <td><?php echo $user['name']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo $user['address']; ?></td>
                                <td><?php echo $user['gender']; ?></td>
                                <td><?php echo $user['dob']; ?></td>
                                <td><?php echo $user['phone']; ?></td>
                                <td><?php echo $user['status']; ?></td>
                                <td>
                                    <!-- Block Button -->
                                    <?php if ($user['status'] == 'active'): ?>
                                        <a href="dashboard.php?action=block&user_id=<?php echo $user['id']; ?>&tab=pills-users" class="btn btn-warning btn-sm">Block</a>
                                    <?php else: ?>
                                        <!-- Unblock Button -->
                                        <a href="dashboard.php?action=unblock&user_id=<?php echo $user['id']; ?>&tab=pills-users" class="btn btn-success btn-sm">Unblock</a>
                                    <?php endif; ?>

                                    <!-- Delete Button -->
                                    <a href="dashboard.php?action=delete&user_id=<?php echo $user['id']; ?>&tab=pills-users" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">No users found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Posts Tab -->
        <div class="tab-pane fade <?php echo isset($_GET['tab']) && $_GET['tab'] == 'pills-posts' ? 'show active' : ''; ?>" id="pills-posts" role="tabpanel" aria-labelledby="pills-posts-tab">
            <h4>Posts List</h4>
            <!-- Posts Table -->
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($post_result->num_rows > 0): ?>
                        <?php while ($post = $post_result->fetch_assoc()): ?>
                            <tr>
                                <th scope="row"><?php echo $post['id']; ?></th>
                                <td><?php echo $post['name']; ?></td>
                                <td><?php echo $post['message']; ?></td>
                                <td><?php echo $post['status']; ?></td>
                                <td>
                                    <!-- Delete Post Button -->
                                    <a href="dashboard.php?delete_post_id=<?php echo $post['id']; ?>&tab=pills-posts" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No posts found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
