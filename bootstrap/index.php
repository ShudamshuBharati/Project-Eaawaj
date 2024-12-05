<?php
include 'dbconnect.php'; // Include the database connection

// Fetch the first 10 posts from the database
$sql = "SELECT * FROM post ORDER BY date DESC LIMIT 10";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-AAWAJ</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles.css">
    <!-- External CSS -->
</head>
<body class="body">

<!-- Navbar -->
<?php include 'navbar.php'; ?>

<!-- Hero Section -->
<div class="hero">
    <h1>Welcome to E-AAWAJ</h1>
</div>

<!-- Posts Section -->
<section id="posts" class="container py-5">
    <h2 class="text-center mb-4">Recent Posts</h2>

    <?php if ($result->num_rows > 0): ?>
        <div class="list-group">
            <?php while ($row = $result->fetch_assoc()): ?>
                <a href="/bootstrap/post.php?id=<?php echo $row['id']; ?>" class="list-group-item list-group-item-action">
                    <h5><?php echo htmlspecialchars($row['name']); ?></h5>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($row['status']); ?></p>
                    <p><strong>Message:</strong> <?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
                    <p><small><strong>Posted on:</strong> <?php echo $row['date']; ?></small></p>
                </a>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No posts available.</p>
    <?php endif; ?>
</section>


<!-- About Section -->
<section id="about" class="container py-5">
    <h2 class="text-center mb-4">About Us</h2>
    <p>E-AAWAJ is a platform dedicated to helping people facing harassment and violence. We provide a secure and private way to file complaints, ensuring anonymity and confidentiality.</p>
</section>

<!-- Contact Section -->
<section id="contact" class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-4">Contact Us</h2>
        <form method="POST" action="createpostlogic.php">
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</section>

<?php include 'footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
