<?php
// Include the database connection
include('dbconnect.php');

// Start the session to access session variables
session_start();

// Check if the 'id' parameter is in the URL query string
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Prepare and execute the SQL query to fetch the post data
    $sql = "SELECT id, name, message, status, date FROM post WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the post exists
    if ($result->num_rows > 0) {
        // Fetch the post details
        $post = $result->fetch_assoc();
    } else {
        $error_message = "Post not found!";
    }

    $stmt->close();
} else {
    $error_message = "No post ID provided!";
}

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
    // Get the commenter from session (assuming it's stored in the session as 'username')
    if (isset($_SESSION['user_name'])) {
        $commenter = $_SESSION['user_name'];
    } else {
        $error_message = "You must be logged in to comment.";
    }

    $comment = $_POST['comment'];

    // Insert the comment into the database
    if (!isset($error_message)) {
        $sql = "INSERT INTO comment (postId, comment, commenter) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $post_id, $comment, $commenter);

        if ($stmt->execute()) {
            $success_message = "Comment added successfully!";
        } else {
            $error_message = "Failed to add comment.";
        }

        $stmt->close();
    }
}

// Fetch all comments for the post
$comments_sql = "SELECT commenter, comment,date FROM comment WHERE postId = ? ORDER BY date DESC";
$comments_stmt = $conn->prepare($comments_sql);
$comments_stmt->bind_param("i", $post_id);
$comments_stmt->execute();
$comments_result = $comments_stmt->get_result();

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Details - E-AAWAJ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="post.css">
    <style>
        /* Custom CSS for post page */
        .post-container {
            margin-top: 50px;
        }

        .post-title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .post-status {
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .post-message {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .post-date {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .error-message {
            color: red;
            font-size: 1.2rem;
            text-align: center;
            margin-top: 50px;
        }

        .success-message {
            color: green;
            font-size: 1.2rem;
            text-align: center;
            margin-top: 20px;
        }

        .comment-form {
            margin-top: 30px;
        }

        .comments-section {
            margin-top: 40px;
        }

        .comment-item {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .commenter-name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .comment-date {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .comment-text {
            font-size: 1rem;
            line-height: 1.5;
        }
    </style>
</head>
<body>
<div class="container post-container">
    <h2 class="text-center mb-4">Post Details</h2>

    <?php if (isset($error_message)): ?>
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php elseif (isset($success_message)): ?>
        <p class="success-message"><?php echo $success_message; ?></p>
    <?php else: ?>
        <div class="post">
            <h3 class="post-title"><?php echo htmlspecialchars($post['name']); ?></h3>
            <p class="post-status"><strong>Status:</strong> <?php echo htmlspecialchars($post['status']); ?></p>
            <p class="post-message"><?php echo nl2br(htmlspecialchars($post['message'])); ?></p>
            <p class="post-date"><small><strong>Posted on:</strong> <?php echo $post['date']; ?></small></p>
        </div>
    <?php endif; ?>

    <!-- Comment form -->
    <div class="comment-form">
        <h4>Add a Comment</h4>
        <form method="POST" action="">
            <!-- Removed the input for name, as it's fetched from the session -->
            <div class="mb-3">
                <label for="comment" class="form-label">Your Comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Comment</button>
        </form>
    </div>

    <!-- Comments section -->
    <div class="comments-section">
        <h4>Comments</h4>

        <?php if ($comments_result->num_rows > 0): ?>
            <?php while ($comment = $comments_result->fetch_assoc()): ?>
                <div class="comment-item">
                    <p class="commenter-name"><?php echo htmlspecialchars($comment['commenter']); ?></p>
                    <p class="comment-date"><?php echo $comment['date']; ?></p>
                    <p class="comment-text"><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No comments yet. Be the first to comment!</p>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php if (isset($success_message)): ?>
    <script>
        alert("<?php echo $success_message; ?>");
    </script>
<?php endif; ?>

</body>
</html>
